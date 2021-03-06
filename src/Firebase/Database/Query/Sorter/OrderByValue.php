<?php

declare(strict_types=1);

namespace ShahPush\Firebase\Database\Query\Sorter;

use ShahPush\Firebase\Database\Query\ModifierTrait;
use ShahPush\Firebase\Database\Query\Sorter;
use Psr\Http\Message\UriInterface;

final class OrderByValue implements Sorter
{
    use ModifierTrait;

    public function modifyUri(UriInterface $uri): UriInterface
    {
        return $this->appendQueryParam($uri, 'orderBy', '"$value"');
    }

    public function modifyValue($value)
    {
        if (!\is_array($value)) {
            return $value;
        }

        \asort($value);

        return $value;
    }
}
