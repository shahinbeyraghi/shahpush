<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Value;

use ShahPush\Firebase\Exception\InvalidArgumentException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PhoneNumber implements \JsonSerializable
{
    /** @var string */
    private $value;

    /**
     * @internal
     */
    public function __construct(string $value)
    {
        $util = PhoneNumberUtil::getInstance();

        try {
            $parsed = $util->parse($value);
        } catch (NumberParseException $e) {
            throw new InvalidArgumentException('Invalid phone number: '.$e->getMessage());
        }

        $this->value = $util->format($parsed, PhoneNumberFormat::E164);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }

    /**
     * @param self|string $other
     */
    public function equalsTo($other): bool
    {
        return $this->value === (string) $other;
    }
}
