<?php

declare(strict_types=1);

namespace ShahPush\Firebase\DynamicLink\CreateDynamicLink;

use InvalidArgumentException;
use ShahPush\Firebase\DynamicLink\CreateDynamicLink;
use ShahPush\Firebase\Exception\FirebaseException;
use ShahPush\Firebase\Util\JSON;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

final class FailedToCreateDynamicLink extends RuntimeException implements FirebaseException
{
    /** @var CreateDynamicLink|null */
    private $action;

    /** @var ResponseInterface|null */
    private $response;

    public static function withActionAndResponse(CreateDynamicLink $action, ResponseInterface $response): self
    {
        $fallbackMessage = 'Failed to create dynamic link';

        try {
            $message = JSON::decode((string) $response->getBody(), true)['error']['message'] ?? $fallbackMessage;
        } catch (InvalidArgumentException $e) {
            $message = $fallbackMessage;
        }

        $error = new self($message);
        $error->action = $action;
        $error->response = $response;

        return $error;
    }

    public function action(): ?CreateDynamicLink
    {
        return $this->action;
    }

    public function response(): ?ResponseInterface
    {
        return $this->response;
    }
}
