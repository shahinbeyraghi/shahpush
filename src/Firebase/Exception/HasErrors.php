<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception;

/**
 * @codeCoverageIgnore
 */
trait HasErrors
{
    /** @var string[] */
    protected $errors = [];

    /**
     * @return string[]
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
