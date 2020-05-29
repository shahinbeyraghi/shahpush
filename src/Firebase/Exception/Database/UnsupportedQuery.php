<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception\Database;

use ShahPush\Firebase\Database\Query;
use ShahPush\Firebase\Exception\DatabaseException;
use RuntimeException;
use Throwable;

final class UnsupportedQuery extends RuntimeException implements DatabaseException
{
    /** @var Query */
    private $query;

    public function __construct(Query $query, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->query = $query;
    }

    public function getQuery(): Query
    {
        return $this->query;
    }
}
