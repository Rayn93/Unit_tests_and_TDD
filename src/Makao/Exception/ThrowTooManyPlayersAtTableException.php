<?php
namespace Makao\Exception;

use Throwable;

class ThrowTooManyPlayersAtTableException extends \RuntimeException
{
    public function __construct(int $max, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('Max capacity is %s players!', $max), $code, $previous);
    }
}

