<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Auth\SignIn;

use ShahPush\Firebase\Auth\SignIn;
use ShahPush\Firebase\Auth\SignInResult;
use ShahPush\Firebase\Exception\InvalidArgumentException;

interface Handler
{
    /**
     * @throws InvalidArgumentException If the handler does not support this action
     * @throws FailedToSignIn
     */
    public function handle(SignIn $action): SignInResult;
}
