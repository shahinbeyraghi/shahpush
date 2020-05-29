<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception\Messaging;

use ShahPush\Firebase\Exception\HasErrors;
use ShahPush\Firebase\Exception\MessagingException;
use RuntimeException;

final class ApiConnectionFailed extends RuntimeException implements MessagingException
{
    use HasErrors;
}
