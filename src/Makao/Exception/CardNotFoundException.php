<?php
namespace Makao\Exception;

use Throwable;

class CardNotFoundException extends \RuntimeException
{
    public function __construct(int $code = 0, Throwable $previous = null)
    {
        parent::__construct('Card collection is empty', $code, $previous);
    }
}

