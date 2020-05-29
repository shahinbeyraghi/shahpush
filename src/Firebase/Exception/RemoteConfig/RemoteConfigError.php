<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception\RemoteConfig;

use ShahPush\Firebase\Exception\RemoteConfigException;
use RuntimeException;

final class RemoteConfigError extends RuntimeException implements RemoteConfigException
{
}
