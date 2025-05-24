<?php
declare(strict_types=1);

namespace Presentation\RequestHandlers\Api;

use Easy\Router\Attributes\Route;
use Easy\Router\Enums\RequestMethod;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Presentation\RequestHandlers\Api\Api;
use Presentation\Response\JsonResponse;
use Shared\Infrastructure\Services\ModelRegistry;
use Presentation\EventStream\Streamer;
use Option\Infrastructure\OptionResolver;

class CostPreviewApiController extends Api
{
    public function __construct(
        private ModelRegistry $modelRegistry,
        private Streamer $streamer,
        private OptionResolver $optionResolver
    ) {}

    #[Route(path: '/api/cost-preview/rates', method: RequestMethod::GET)]
    public function getRates(ServerRequestInterface $request): ResponseInterface
    {
        try {
            // Get the credit rates from Aikeedo's internal system
            $allOptions = $this->optionResolver->getOptionMap();
            $creditRates = $allOptions['option.credit_rate'] ?? [];
            
            return new JsonResponse([
                'status' => 'success',
                'data' => [
                    'rates' => $creditRates
                ]
            ]);
        } catch (\Exception $e) {
            error_log("CostPreview getRates Error: " . $e->getMessage());
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Failed to get credit rates: ' . $e->getMessage()
            ], 500);
        }
    }

    #[Route(path: '/api/cost-preview/estimate', method: RequestMethod::POST)]
    public function estimate(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $data = $request->getParsedBody();
            $prompt = $data['prompt'] ?? '';
            $modelId = $data['model'] ?? 'gpt-3.5-turbo';
            
            // Debug logging
            error_log("CostPreview API called - Model: $modelId, Prompt length: " . strlen($prompt));
            
            // Token-Berechnung (vereinfacht)
            $inputTokens = $this->calculateTokens($prompt);
            $outputTokens = min($inputTokens * 2, 2000); // Geschätzt
            
            // Get Aikeedo's internal credit rates
            $allOptions = $this->optionResolver->getOptionMap();
            $creditRates = $allOptions['option.credit_rate'] ?? [];
            
            // Model-Kosten aus Aikeedo's internen Raten abrufen
            $costPerInputToken = 0.0001; // Default fallback
            $costPerOutputToken = 0.0002; // Default fallback
            
            // Try to get the actual Aikeedo rates for this model
            $inputRateKey = $modelId . '-input';
            $outputRateKey = $modelId . '-output';
            
            if (isset($creditRates[$inputRateKey])) {
                $costPerInputToken = (float) $creditRates[$inputRateKey];
                error_log("Using Aikeedo rate for input: $costPerInputToken");
            } else {
                error_log("No Aikeedo rate found for input key: $inputRateKey");
            }
            
            if (isset($creditRates[$outputRateKey])) {
                $costPerOutputToken = (float) $creditRates[$outputRateKey];
                error_log("Using Aikeedo rate for output: $costPerOutputToken");
            } else {
                error_log("No Aikeedo rate found for output key: $outputRateKey");
            }
            
            $inputCost = $inputTokens * $costPerInputToken;
            $outputCost = $outputTokens * $costPerOutputToken;
            $totalCost = $inputCost + $outputCost;
            
            return new JsonResponse([
                'status' => 'success',
                'data' => [
                    'input_tokens' => $inputTokens,
                    'assumed_output_tokens' => $outputTokens,
                    'total_estimated_credits' => round($totalCost, 4),
                    'input_cost' => round($inputCost, 4),
                    'output_cost' => round($outputCost, 4),
                    'currency' => 'Credits',
                    'message' => 'Geschätzte Kosten basierend auf Aikeedo Credit-Raten',
                    'model' => $modelId,
                    'rates_used' => [
                        'input_rate' => $costPerInputToken,
                        'output_rate' => $costPerOutputToken,
                        'input_rate_key' => $inputRateKey,
                        'output_rate_key' => $outputRateKey
                    ],
                    'available_rates' => array_keys($creditRates) // For debugging
                ]
            ]);
            
        } catch (\Exception $e) {
            error_log("CostPreview Error: " . $e->getMessage());
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Fehler bei der Kostenschätzung: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function calculateTokens(string $text): int
    {
        // Vereinfachte Token-Berechnung
        $words = str_word_count($text);
        return (int)($words * 1.3);
    }
}