<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception;

interface MessagingException extends FirebaseException
{
    /**
     * @return string[]
     */
    public function errors(): array;
}
