<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Http;

use InvalidArgumentException;
use ShahPush\Firebase\Util\JSON;
use Psr\Http\Message\ResponseInterface;

final class ErrorResponseParser
{
    public function getErrorReasonFromResponse(ResponseInterface $response): string
    {
        $responseBody = (string) $response->getBody();

        try {
            $data = JSON::decode($responseBody, true);
        } catch (InvalidArgumentException $e) {
            return $responseBody;
        }

        if (\is_string($data['error']['message'] ?? null)) {
            return $data['error']['message'];
        }

        if (\is_string($data['error'] ?? null)) {
            return $data['error'];
        }

        return $responseBody;
    }

    /**
     * @return array<mixed>
     */
    public function getErrorsFromResponse(ResponseInterface $response): array
    {
        try {
            return JSON::decode((string) $response->getBody(), true);
        } catch (InvalidArgumentException $e) {
            return [];
        }
    }
}
