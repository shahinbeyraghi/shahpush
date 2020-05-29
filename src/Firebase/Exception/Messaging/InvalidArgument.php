<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception\Messaging;

use InvalidArgumentException;
use ShahPush\Firebase\Exception\HasErrors;
use ShahPush\Firebase\Exception\MessagingException;

final class InvalidArgument extends InvalidArgumentException implements MessagingException
{
    use HasErrors;
}
