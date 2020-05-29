<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Http;

interface HasSubRequests
{
    public function subRequests(): Requests;
}
