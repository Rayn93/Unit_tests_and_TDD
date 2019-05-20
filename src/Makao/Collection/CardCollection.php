<?php
namespace Makao\Collection;

use Makao\Card;
use Makao\Exception\CardNotFoundException;
use Makao\Exception\MethodNotAllowException;

class CardCollection implements \Countable, \Iterator, \ArrayAccess
{
    private const FIRST_POSITION = 0;

    private $cards = [];
    private $position = 0;

    public function count() : int
    {
        return count($this->cards);
    }

    public function addCard(Card $card) : self
    {
        $this->cards[] = $card;

        return $this;

    }

    public function pickCard() : Card
    {
        if (empty($this->cards)){
            throw new CardNotFoundException();
        }

        $pieckedCard = $this->offsetGet(self::FIRST_POSITION);
        $this->offsetUnset(self::FIRST_POSITION);

        $this->cards = array_values($this->cards);

        return $pieckedCard;
    }

    private function removeLastCard() : void
    {
        array_shift($this->cards);
    }


    /**
     * @inheritdoc
     */
    public function current() : ?Card
    {
        return $this->cards[$this->position];
    }

    /**
     * @inheritdoc
     */
    public function next() : void
    {
        ++$this->position;
    }

    /**
     * @inheritdoc
     */
    public function key() : int
    {
        return $this->position;
    }

    /**
     * @inheritdoc
     */
    public function valid() : bool
    {
        return (bool) $this->cards[$this->position];
    }

    /**
     * @inheritdoc
     */
    public function rewind() : void
    {
        $this->position = self::FIRST_POSITION;
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset) : bool
    {
        return isset($this->cards[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset) : Card
    {
        return $this->cards[$offset];
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        throw new MethodNotAllowException('You can not add card to collection as Array. Use addCard() method');
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset) : void
    {
        unset($this->cards[$offset]);
    }

    public function shuffle()
    {
        shuffle($this->cards);
    }

}





