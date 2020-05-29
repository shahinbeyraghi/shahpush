<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Messaging;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use ShahPush\Firebase\Exception\FirebaseException;
use ShahPush\Firebase\Exception\MessagingApiExceptionConverter;
use ShahPush\Firebase\Exception\MessagingException;
use ShahPush\Firebase\Http\WrappedGuzzleClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @internal
 */
class ApiClient implements ClientInterface
{
    use WrappedGuzzleClient;

    /** @var MessagingApiExceptionConverter */
    private $errorHandler;

    /**
     * @internal
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->errorHandler = new MessagingApiExceptionConverter();
    }

    /**
     * @param array<string, mixed> $options
     *
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        try {
            return $this->client->send($request);
        } catch (Throwable $e) {
            throw $this->errorHandler->convertException($e);
        }
    }

    /**
     * @param array<string, mixed> $options
     */
    public function sendAsync(RequestInterface $request, array $options = []): PromiseInterface
    {
        return $this->client->sendAsync($request, $options)
            ->then(null, function (Throwable $e): void {
                throw $this->errorHandler->convertException($e);
            });
    }
}
