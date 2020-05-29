<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Http;

interface HasSubResponses
{
    public function subResponses(): Responses;
}
