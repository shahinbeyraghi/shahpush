<?php

declare(strict_types=1);

namespace ShahPush\Firebase\DynamicLink\CreateDynamicLink;

use ShahPush\Firebase\DynamicLink;
use ShahPush\Firebase\DynamicLink\CreateDynamicLink;

interface Handler
{
    /**
     * @throws FailedToCreateDynamicLink
     */
    public function handle(CreateDynamicLink $action): DynamicLink;
}
