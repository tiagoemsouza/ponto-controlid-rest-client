<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Adapter;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use tiagoemsouza\ControlIdAPI\Exception\AccessDeniedException;
use tiagoemsouza\ControlIdAPI\Exception\ForbiddenException;
use tiagoemsouza\ControlIdAPI\Exception\InternalServerErrorException;
use tiagoemsouza\ControlIdAPI\Exception\NotFoundException;
use tiagoemsouza\ControlIdAPI\Exception\UnauthorizedException;

abstract class AbstractAdapter implements AdapterInterface
{

    private const CLIENT_CONFIG = [
        'base_uri' => 'http://ip-do-relogio',
    ];

    private const DEFAULT_OPTIONS = [
        'http_errors' => false,
        'headers' => [
            'Content-Type' => 'application/json',
        ],
    ];

    private Client $client;

    protected string $session;

    public function __construct(?Client $client = null)
    {
        if ($client == null) {
            $client = new Client(self::CLIENT_CONFIG);
        }

        $this->client = $client;
    }

    public function loadSession(string $session): void
    {
        $this->session = $session;
    }

    /**
     * Performs a request to the API.
     *
     * @param string $method HTTP method
     * @param string $path Path to the resource
     * @param array<string, mixed> $queryParams Query parameters
     * @return mixed[]
     */
    protected function request(string $method, string $path, array $queryParams = []): array
    {

        $options = self::DEFAULT_OPTIONS;

        if (!empty($this->session)) {
            $options['query']['session'] = $this->session;
        }

        if (!empty($queryParams)) {
            $options['body'] = json_encode($queryParams);
        }

        $response = $this->client->request($method, $path, $options);

        $this->handleErrors($response);

        return $this->parseResponseBody($response);
    }

    /**
     * Handles request errors.
     *
     * @param ResponseInterface $response
     * @throws NotFoundException
     * @return void
     */
    private function handleErrors(ResponseInterface $response): void
    {

        if ($response->getStatusCode() === 400) {
            throw new AccessDeniedException($response);
        }

        if ($response->getStatusCode() === 401) {
            throw new UnauthorizedException($response);
        }

        if ($response->getStatusCode() === 403) {
            throw new ForbiddenException($response);
        }

        if ($response->getStatusCode() === 404) {
            throw new NotFoundException($response);
        }

        if ($response->getStatusCode() === 500) {
            throw new InternalServerErrorException($response);
        }
    }

    /**
     * Parses the response body.
     *
     * @return mixed[]
     */
    private function parseResponseBody(ResponseInterface $response): array
    {

        $responseBodyContent = $response->getBody()->getContents();

        $isBase64 = preg_match('/^data:text\/plain;base64,(.*)/m', $responseBodyContent, $matches);

        if (!$isBase64) {
            $data = json_decode($responseBodyContent, true);
        } else {
            $data['data'] = $matches[1];
        }

        $data = is_array($data) ? $data : [$data];

        return $data;
    }
}
