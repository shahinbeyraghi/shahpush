<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Auth\SendActionLink;

use ShahPush\Firebase\Auth\SendActionLink;

interface Handler
{
    /**
     * @throws FailedToSendActionLink
     */
    public function handle(SendActionLink $action): void;
}
