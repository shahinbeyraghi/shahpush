<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Auth\CreateActionLink;

use ShahPush\Firebase\Auth\CreateActionLink;

interface Handler
{
    /**
     * @throws FailedToCreateActionLink
     */
    public function handle(CreateActionLink $action): string;
}
