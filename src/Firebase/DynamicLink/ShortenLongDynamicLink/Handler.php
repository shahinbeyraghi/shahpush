<?php

declare(strict_types=1);

namespace ShahPush\Firebase\DynamicLink\ShortenLongDynamicLink;

use ShahPush\Firebase\DynamicLink;
use ShahPush\Firebase\DynamicLink\ShortenLongDynamicLink;

interface Handler
{
    /**
     * @throws FailedToShortenLongDynamicLink
     */
    public function handle(ShortenLongDynamicLink $action): DynamicLink;
}
