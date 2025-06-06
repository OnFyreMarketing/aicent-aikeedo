<?php

declare(strict_types=1);

namespace Ai\Infrastructure\Services\Anthropic;

use Ai\Domain\Completion\CompletionServiceInterface;
use Ai\Domain\Exceptions\ApiException;
use Ai\Domain\ValueObjects\Chunk;
use Ai\Domain\ValueObjects\Model;
use Ai\Infrastructure\Services\CostCalculator;
use Billing\Domain\ValueObjects\CreditCount;
use Generator;
use Override;
use Traversable;

class CompletionService implements CompletionServiceInterface
{
    private array $models = [
        'claude-3-7-sonnet-latest',
        'claude-3-5-sonnet-latest',
        'claude-3-5-haiku-latest',
        'claude-3-opus-20240229',
        'claude-3-sonnet-20240229',
        'claude-3-haiku-20240307'
    ];

    public function __construct(
        private Client $client,
        private CostCalculator $calc
    ) {}

    #[Override]
    public function generateCompletion(Model $model, array $params = []): Generator
    {
        $prompt = $params['prompt'] ?? '';

        $body = [
            'model' => $model->value,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt
                ],
            ],
            'max_tokens' => 4096,
            'stream' => true,
            // 'system' => 'System message here',
        ];

        if (isset($params['temperature'])) {
            $body['temperature'] = (float)$params['temperature'] / 2;
        }

        $resp = $this->client->sendRequest('POST', '/v1/messages', $body);
        $stream = new StreamResponse($resp);

        $inputTokensCount = 0;
        $outputTokensCount = 0;

        foreach ($stream as $data) {
            $type = $data->type ?? null;

            if ($type === 'error') {
                throw new ApiException($data->error->message);
            }

            if ($type == 'message_start') {
                $inputTokensCount += $data->message->usage->input_tokens ?? 0;
                $outputTokensCount += $data->message->usage->output_tokens ?? 0;

                continue;
            }

            if ($type == 'content_block_delta') {
                $content = $data->delta->text ?? null;

                if ($content) {
                    yield new Chunk($content);
                }

                continue;
            }

            if ($type == 'message_delta') {
                $inputTokensCount += $data->usage->input_tokens ?? 0;
                $outputTokensCount += $data->usage->output_tokens ?? 0;

                continue;
            }
        }

        if ($this->client->hasCustomKey()) {
            // Cost is not calculated for custom keys,
            $cost = new CreditCount(0);
        } else {
            $inputCost = $this->calc->calculate(
                $inputTokensCount,
                $model,
                CostCalculator::INPUT
            );

            $outputCost = $this->calc->calculate(
                $outputTokensCount,
                $model,
                CostCalculator::OUTPUT
            );

            $cost = new CreditCount($inputCost->value + $outputCost->value);
        }

        return $cost;
    }

    #[Override]
    public function supportsModel(Model $model): bool
    {
        return in_array($model->value, $this->models);
    }

    #[Override]
    public function getSupportedModels(): Traversable
    {
        foreach ($this->models as $model) {
            yield new Model($model);
        }
    }
}
