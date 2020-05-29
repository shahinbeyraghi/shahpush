<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception;

use Fig\Http\Message\StatusCodeInterface as StatusCode;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use ShahPush\Firebase\Exception\Database\ApiConnectionFailed;
use ShahPush\Firebase\Exception\Database\DatabaseError;
use ShahPush\Firebase\Http\ErrorResponseParser;
use Throwable;

/**
 * @internal
 */
class DatabaseApiExceptionConverter
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

    public function convertException(Throwable $exception): DatabaseException
    {
        if ($exception instanceof RequestException) {
            return $this->convertGuzzleRequestException($exception);
        }

        return new DatabaseError($exception->getMessage(), $exception->getCode(), $exception);
    }

    private function convertGuzzleRequestException(RequestException $e): DatabaseException
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

        switch ($code) {
            case StatusCode::STATUS_UNAUTHORIZED:
            case StatusCode::STATUS_FORBIDDEN:
                return new Database\PermissionDenied($message, $code, $e);
            case StatusCode::STATUS_PRECONDITION_FAILED:
                return new Database\PreconditionFailed($message, $code, $e);
        }

        return new DatabaseError($message, $code, $e);
    }
}
