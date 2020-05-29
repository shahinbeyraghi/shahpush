<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Exception\Database;

use ShahPush\Firebase\Exception\DatabaseException;
use RuntimeException;

final class DatabaseError extends RuntimeException implements DatabaseException
{
}
