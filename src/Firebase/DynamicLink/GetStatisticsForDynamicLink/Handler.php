<?php

declare(strict_types=1);

namespace ShahPush\Firebase\DynamicLink\GetStatisticsForDynamicLink;

use ShahPush\Firebase\DynamicLink\DynamicLinkStatistics;
use ShahPush\Firebase\DynamicLink\GetStatisticsForDynamicLink;

interface Handler
{
    public function handle(GetStatisticsForDynamicLink $action): DynamicLinkStatistics;
}
