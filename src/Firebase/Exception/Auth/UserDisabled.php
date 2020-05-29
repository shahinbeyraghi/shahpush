<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception\Auth;

use ShahPush\Firebase\Exception\AuthException;
use RuntimeException;

final class UserDisabled extends RuntimeException implements AuthException
{
}
