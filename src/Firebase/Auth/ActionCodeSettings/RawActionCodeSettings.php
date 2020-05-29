<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Auth\ActionCodeSettings;

use ShahPush\Firebase\Auth\ActionCodeSettings;

final class RawActionCodeSettings implements ActionCodeSettings
{
    /** @var array<mixed> */
    private $settings;

    /**
     * @param array<mixed> $settings
     */
    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->settings;
    }
}
