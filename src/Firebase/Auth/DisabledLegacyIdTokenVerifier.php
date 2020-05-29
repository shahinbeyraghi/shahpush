<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Auth;

use Firebase\Auth\Token\Domain\Verifier;
use ShahPush\Firebase\Exception\RuntimeException;
use Lcobucci\JWT\Token;

final class DisabledLegacyIdTokenVerifier implements Verifier
{
    /** @var string */
    private $reason;

    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }

    public function verifyIdToken($token): Token
    {
        throw new RuntimeException($this->reason);
    }
}
