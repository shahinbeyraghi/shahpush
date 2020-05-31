<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Messaging\Http\Request;

use ShahPush\Firebase\Exception\InvalidArgumentException;
use ShahPush\Firebase\Http\HasSubRequests;
use ShahPush\Firebase\Http\Requests;
use ShahPush\Firebase\Http\RequestWithSubRequests;
use ShahPush\Firebase\Http\WrappedPsr7Request;
use ShahPush\Firebase\Messaging\Messages;
use Psr\Http\Message\RequestInterface;

final class SendMessages implements HasSubRequests, RequestInterface
{
    public const MAX_AMOUNT_OF_MESSAGES = 500;

    use WrappedPsr7Request;

    public function __construct(string $projectId, Messages $messages)
    {
        if ($messages->count() > self::MAX_AMOUNT_OF_MESSAGES) {
            throw new InvalidArgumentException('Only '.self::MAX_AMOUNT_OF_MESSAGES.' can be sent at a time.');
        }

        $subRequests = [];

        $index = 0;

        foreach ($messages as $message) {
            $subRequests[] = (new SendMessage($projectId, $message));
                // see https://github.com/firebase/firebase-admin-node/blob/master/src/messaging/batch-request.ts#L104
                //->withHeader('Content-ID', (string) ++$index)
                //->withHeader('Content-Transfer-Encoding', 'binary')
                //->withHeader('Content-Type', 'application/http');
        }

        /**
         * change in push package by shahin
         */
        $this->wrappedRequest = new RequestWithSubRequests(
            'http://127.0.0.1/push/web/notification/publish',
            new Requests(...$subRequests)
        );
    }
}
