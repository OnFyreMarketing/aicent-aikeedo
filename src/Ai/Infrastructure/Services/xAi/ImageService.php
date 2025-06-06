<?php

declare(strict_types=1);

namespace Ai\Infrastructure\Services\xAi;

use Ai\Domain\Entities\ImageEntity;
use Ai\Domain\Exceptions\DomainException;
use Ai\Domain\Exceptions\ModelNotSupportedException;
use Ai\Domain\Image\ImageServiceInterface;
use Ai\Domain\ValueObjects\Model;
use Ai\Domain\ValueObjects\RequestParams;
use Ai\Domain\ValueObjects\State;
use Ai\Infrastructure\Services\CostCalculator;
use Easy\Container\Attributes\Inject;
use File\Domain\Entities\ImageFileEntity;
use File\Domain\ValueObjects\Height;
use File\Domain\ValueObjects\ObjectKey;
use File\Domain\ValueObjects\Size;
use File\Domain\ValueObjects\Storage;
use File\Domain\ValueObjects\Url;
use File\Domain\ValueObjects\Width;
use File\Infrastructure\BlurhashGenerator;
use Override;
use Shared\Infrastructure\FileSystem\CdnInterface;
use Shared\Infrastructure\Services\ModelRegistry;
use Traversable;
use User\Domain\Entities\UserEntity;
use Workspace\Domain\Entities\WorkspaceEntity;

class ImageService implements ImageServiceInterface
{
    private array $models = [];

    public function __construct(
        private Client $client,
        private CostCalculator $calc,
        private CdnInterface $cdn,
        private ModelRegistry $registry,

        #[Inject('option.features.imagine.is_enabled')]
        private bool $isToolEnabled = false,
    ) {
        $models = [];

        if ($isToolEnabled) {
            foreach ($this->registry['directory'] as $service) {
                if ($service['key'] !== 'xai') {
                    continue;
                }

                foreach ($service['models'] as $model) {
                    if (
                        $model['type'] !== 'image'
                        || !($model['enabled'] ?? false)
                    ) {
                        continue;
                    }

                    $models[] = $model['key'];
                }
            }
        }

        $this->models = $models;
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

    #[Override]
    public function generateImage(
        WorkspaceEntity $workspace,
        UserEntity $user,
        Model $model,
        ?array $params = null
    ): ImageEntity {
        if (!$this->supportsModel($model)) {
            throw new ModelNotSupportedException(
                self::class,
                $model
            );
        }

        if (!$params || !array_key_exists('prompt', $params)) {
            throw new DomainException('Missing parameter: prompt');
        }

        $endpoint = '/v1/images/generations';
        $headers = [];

        $data = [
            'prompt' => $params['prompt'],
            'model' => $model->value
        ];

        $resp = $this->client->sendRequest('POST', $endpoint, $data, headers: $headers);
        $resp = json_decode($resp->getBody()->getContents());

        $url = $resp->data[0]->url;
        $resp = $this->client->sendRequest('GET', $url);
        $content = $resp->getBody()->getContents();

        $cost = $this->calc->calculate(1, $model);

        // Save image to CDN
        $name = $this->cdn->generatePath('png', $workspace, $user);
        $this->cdn->write($name, $content);

        $img = imagecreatefromstring($content);
        $width = imagesx($img);
        $height = imagesy($img);

        $file = new ImageFileEntity(
            new Storage($this->cdn->getAdapterLookupKey()),
            new ObjectKey($name),
            new Url($this->cdn->getUrl($name)),
            new Size(strlen($content)),
            new Width($width),
            new Height($height),
            BlurhashGenerator::generateBlurHash($img, $width, $height),
        );

        $entity = new ImageEntity(
            $workspace,
            $user,
            $model,
            RequestParams::fromArray($params),
            $cost
        );

        $entity->setOutputFile($file);
        $entity->setState(State::COMPLETED);

        return $entity;
    }
}
