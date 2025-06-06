<?php

declare(strict_types=1);

namespace Ai\Infrastructure\Services\xAi;

use Ai\Domain\Exceptions\ApiException;
use Easy\Container\Attributes\Inject;
use Http\Message\MultipartStream\MultipartStreamBuilder;
use InvalidArgumentException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use function \safe_json_encode;

class Client
{
    private const BASE_URL = "https://api.x.ai/";

    public function __construct(
        private ClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,

        #[Inject('option.xai.api_key')]
        private ?string $apiKey = null,
    ) {}

    /**
     * @throws InvalidArgumentException
     * @throws ClientExceptionInterface
     * @throws ApiException
     */
    public function sendRequest(
        string $method,
        string $path,
        array $body = [],
        array $params = [],
        array $headers = []
    ): ResponseInterface {
        $path = parse_url($path, PHP_URL_SCHEME) !== null
            ? $path
            : self::BASE_URL . ltrim($path, '/');

        $req = $this->requestFactory
            ->createRequest($method, $path)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json');

        if ($this->apiKey) {
            $req = $req->withHeader('Authorization', 'Bearer ' . $this->apiKey);
        }

        if ($params) {
            $req = $req->withUri(
                $req->getUri()->withQuery(http_build_query($params))
            );
        }

        foreach ($headers as $key => $value) {
            $req = $req->withHeader($key, $value);
        }

        $isMultiPart = false;
        $contentType = $req->getHeaderLine('Content-Type');
        if (str_starts_with($contentType, 'multipart/')) {
            $isMultiPart = true;
        }

        if ($isMultiPart) {
            $builder = new MultipartStreamBuilder($this->streamFactory);

            foreach ($body as $key => $value) {
                $builder->addResource($key, $value);
            }

            $multipartStream = $builder->build();
            $boundary = $builder->getBoundary();

            $req = $req
                ->withHeader('Content-Type', 'multipart/form-data; boundary=' . $boundary)
                ->withBody($multipartStream);
        } else {
            if ($body) {
                $stream = $req->getBody();
                $stream->write(safe_json_encode($body, JSON_THROW_ON_ERROR));
                $req = $req->withBody($stream);
            }
        }

        $resp = $this->client->sendRequest($req);
        $code = $resp->getStatusCode();

        if ($code === 401) {
            throw new ApiException('Incorrect xAI API key provided. Please contact your workspace owner.');
        } elseif ($code < 200 || $code >= 300) {
            $contents = $resp->getBody()->getContents();
            $body = json_decode($contents);

            $msg = $body ? ($body->error->message ?? $body->error ?? $body->error->code ?? $body->code ?? 'Unexpected error occurred while communicating with xAI API') : $contents;
            if (!is_string($msg)) {
                $msg = json_encode($msg);
            }

            throw new ApiException($msg);
        }

        return $resp;
    }
}
