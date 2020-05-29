<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Auth;

use Firebase\Auth\Token\Domain\Generator;
use ShahPush\Firebase\Exception\RuntimeException;
use ShahPush\Firebase\Value\Uid;
use Lcobucci\JWT\Token;

final class DisabledLegacyCustomTokenGenerator implements Generator
{
    /** @var string */
    private $reason;

    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }

    /**
     * @param Uid|string $uid
     * @param array<string, mixed> $claims
     */
    public function createCustomToken($uid, array $claims = []): Token
    {
        throw new RuntimeException($this->reason);
    }
}
