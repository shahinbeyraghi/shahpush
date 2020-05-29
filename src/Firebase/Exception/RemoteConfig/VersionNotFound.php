<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception\RemoteConfig;

use ShahPush\Firebase\Exception\RemoteConfigException;
use ShahPush\Firebase\RemoteConfig\VersionNumber;
use RuntimeException;

final class VersionNotFound extends RuntimeException implements RemoteConfigException
{
    public static function withVersionNumber(VersionNumber $versionNumber): self
    {
        return new self('Version #'.$versionNumber.' could not be found.');
    }
}
