<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use ShahPush\Firebase\Exception\Auth\ApiConnectionFailed;
use ShahPush\Firebase\Exception\Auth\AuthError;
use ShahPush\Firebase\Exception\Auth\CredentialsMismatch;
use ShahPush\Firebase\Exception\Auth\EmailExists;
use ShahPush\Firebase\Exception\Auth\EmailNotFound;
use ShahPush\Firebase\Exception\Auth\ExpiredOobCode;
use ShahPush\Firebase\Exception\Auth\InvalidCustomToken;
use ShahPush\Firebase\Exception\Auth\InvalidOobCode;
use ShahPush\Firebase\Exception\Auth\InvalidPassword;
use ShahPush\Firebase\Exception\Auth\MissingPassword;
use ShahPush\Firebase\Exception\Auth\OperationNotAllowed;
use ShahPush\Firebase\Exception\Auth\PhoneNumberExists;
use ShahPush\Firebase\Exception\Auth\ProviderLinkFailed;
use ShahPush\Firebase\Exception\Auth\UserDisabled;
use ShahPush\Firebase\Exception\Auth\UserNotFound;
use ShahPush\Firebase\Exception\Auth\WeakPassword;
use ShahPush\Firebase\Http\ErrorResponseParser;
use Throwable;

/**
 * @internal
 */
class AuthApiExceptionConverter
{
    /** @var ErrorResponseParser */
    private $responseParser;

    /**
     * @internal
     */
    public function __construct()
    {
        $this->responseParser = new ErrorResponseParser();
    }

    /**
     * @return AuthException
     */
    public function convertException(Throwable $exception): FirebaseException
    {
        if ($exception instanceof RequestException) {
            return $this->convertGuzzleRequestException($exception);
        }

        return new AuthError($exception->getMessage(), $exception->getCode(), $exception);
    }

    private function convertGuzzleRequestException(RequestException $e): AuthException
    {
        $message = $e->getMessage();
        $code = $e->getCode();

        if ($e instanceof ConnectException) {
            return new ApiConnectionFailed('Unable to connect to the API: '.$message, $code, $e);
        }

        if ($response = $e->getResponse()) {
            $message = $this->responseParser->getErrorReasonFromResponse($response);
            $code = $response->getStatusCode();
        }

        if (\mb_stripos($message, 'credentials_mismatch') !== false) {
            return new CredentialsMismatch('Invalid custom token: The custom token corresponds to a different Firebase project.', $code, $e);
        }

        if (\mb_stripos($message, 'email_exists') !== false) {
            return new EmailExists('The email address is already in use by another account.', $code, $e);
        }

        if (\mb_stripos($message, 'email_not_found') !== false) {
            return new EmailNotFound('There is no user record corresponding to this identifier. The user may have been deleted.', $code, $e);
        }

        if (\mb_stripos($message, 'invalid_custom_token') !== false) {
            return new InvalidCustomToken('Invalid custom token: The custom token format is incorrect or the token is invalid for some reason (e.g. expired, invalid signature, etc.)', $code, $e);
        }

        if (\mb_stripos($message, 'invalid_password') !== false) {
            return new InvalidPassword('The password is invalid or the user does not have a password.', $code, $e);
        }

        if (\mb_stripos($message, 'missing_password') !== false) {
            return new MissingPassword('Missing Password', $code, $e);
        }

        if (\mb_stripos($message, 'operation_not_allowed') !== false) {
            return new OperationNotAllowed('Operation not allowed.', $code, $e);
        }

        if (\mb_stripos($message, 'user_disabled') !== false) {
            return new UserDisabled('The user account has been disabled by an administrator.', $code, $e);
        }

        if (\mb_stripos($message, 'user_not_found') !== false) {
            return new UserNotFound('There is no user record corresponding to this identifier. The user may have been deleted.', $code, $e);
        }

        if (\mb_stripos($message, 'weak_password') !== false) {
            return new WeakPassword('The password must be 6 characters long or more.', $code, $e);
        }

        if (\mb_stripos($message, 'phone_number_exists') !== false) {
            return new PhoneNumberExists('The phone number is already in use by another account.', $code, $e);
        }

        if (\mb_stripos($message, 'invalid_idp_response') !== false) {
            return new ProviderLinkFailed('The supplied auth credential is malformed or has expired.', $code, $e);
        }

        if (\mb_stripos($message, 'invalid_id_token') !== false) {
            return new ProviderLinkFailed('The user\'s credential is no longer valid. The user must sign in again.', $code, $e);
        }

        if (\mb_stripos($message, 'federated_user_id_already_linked') !== false) {
            return new ProviderLinkFailed('This credential is already associated with a different user account.', $code, $e);
        }

        if (\mb_stripos($message, 'expired_oob_code') !== false) {
            return new ExpiredOobCode('The action code has expired.', $code, $e);
        }

        if (\mb_stripos($message, 'invalid_oob_code') !== false) {
            return new InvalidOobCode('The action code is invalid. This can happen if the code is malformed, expired, or has already been used.', $code, $e);
        }

        return new AuthError($message, $code, $e);
    }
}
