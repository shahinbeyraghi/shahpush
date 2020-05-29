<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception\Messaging;

use ShahPush\Firebase\Exception\HasErrors;
use ShahPush\Firebase\Exception\MessagingException;
use RuntimeException;

final class ServerError extends RuntimeException implements MessagingException
{
    use HasErrors;

    /**
     * @internal
     *
     * @param string[] $errors
     */
    public function withErrors(array $errors): self
    {
        $new = new self($this->getMessage(), $this->getCode(), $this->getPrevious());
        $new->errors = $errors;

        return $new;
    }
}
