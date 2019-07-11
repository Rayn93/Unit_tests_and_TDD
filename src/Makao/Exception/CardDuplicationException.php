<?php
namespace Makao\Exception;

use Makao\Card;
use Throwable;

class CardDuplicationException extends \Exception
{
    public function __construct(Card $card, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Valid card get the same cards: %s %s', $card->getValue(), $card->getColor()),
            $code,
            $previous
        );
    }
}