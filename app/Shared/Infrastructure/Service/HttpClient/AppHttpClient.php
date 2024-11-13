<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class AppHttpClient implements HttpClient
{
    private Method $method = Method::GET;
    private string $uri = '';
    private array $headers = [];
    private array $queryParams = [];
    private array $bodyParams = [];

    public function __construct(
        private readonly Client $guzzleClient,
    ) {
    }

    public function setMethod(Method $method): self
    {
        $this->method = $method;
        return $this;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    public function addHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function addQueryParam(string $name, string $value): self
    {
        $this->queryParams[$name] = $value;
        return $this;
    }

    public function addBodyParam(string $name, $value): self
    {
        $this->bodyParams[$name] = $value;
        return $this;
    }

    public function addBodyParams(array $params): self
    {
        foreach ($params as $name => $value) {
            $this->addBodyParam($name, $value);
        }
        return $this;
    }

    public function send(): ResponseInterface
    {
        $options = [
            'headers' => $this->headers,
            'query' => $this->queryParams,
            'json' => $this->bodyParams,
        ];

        try {
            return $this->guzzleClient->request($this->method->name, $this->uri, $options);

        } catch (GuzzleException $e) {
            throw new \RuntimeException('Error during request: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
