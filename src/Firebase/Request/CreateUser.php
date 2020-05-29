<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Request;

use ShahPush\Firebase\Exception\InvalidArgumentException;
use ShahPush\Firebase\Request;

final class CreateUser implements Request
{
    use EditUserTrait;

    private function __construct()
    {
    }

    public static function new(): self
    {
        return new self();
    }

    /**
     * @param array<string, mixed> $properties
     *
     * @throws InvalidArgumentException when invalid properties have been provided
     */
    public static function withProperties(array $properties): self
    {
        return self::withEditableProperties(new self(), $properties);
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->prepareJsonSerialize();
    }
}
