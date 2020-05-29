<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Messaging\Http\Request;

use ShahPush\Firebase\Exception\InvalidArgumentException;
use ShahPush\Firebase\Http\HasSubRequests;
use ShahPush\Firebase\Http\WrappedPsr7Request;
use ShahPush\Firebase\Messaging\Message;
use ShahPush\Firebase\Messaging\Messages;
use ShahPush\Firebase\Messaging\RawMessageFromArray;
use ShahPush\Firebase\Messaging\RegistrationTokens;
use Psr\Http\Message\RequestInterface;

final class SendMessageToTokens implements HasSubRequests, RequestInterface
{
    public const MAX_AMOUNT_OF_TOKENS = 500;

    use WrappedPsr7Request;

    public function __construct(string $projectId, Message $message, RegistrationTokens $registrationTokens)
    {
        if ($registrationTokens->count() > self::MAX_AMOUNT_OF_TOKENS) {
            throw new InvalidArgumentException('A multicast message can be sent to a maximum amount of '.self::MAX_AMOUNT_OF_TOKENS.' tokens.');
        }

        $messageData = $message->jsonSerialize();
        unset($messageData['topic'], $messageData['condition']);

        $messages = [];

        foreach ($registrationTokens as $token) {
            $messageData['token'] = $token->value();

            $messages[] = new RawMessageFromArray($messageData);
        }

        $this->wrappedRequest = new SendMessages($projectId, new Messages(...$messages));
    }
}
