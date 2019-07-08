<?php
namespace Makao\Validator;

use Makao\Card;

class CardValidator
{
    public function valid(Card $activeCard, Card $newCard) : bool
    {
        return $activeCard->getColor() === $newCard->getColor() || $activeCard->getValue() === $newCard->getValue();
    }
}