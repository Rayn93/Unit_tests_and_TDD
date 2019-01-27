<?php
namespace Makao\Collection;

use Makao\Card;
use Makao\Exception\CardNotFoundException;

class CardCollection implements \Countable, \Iterator
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

        return end($this->cards);
    }


    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current() : ?Card
    {
        return $this->cards[$this->position];
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next() : void
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key() : int
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid() : bool
    {
        return (bool) $this->cards[$this->position];
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind() : void
    {
        $this->position = self::FIRST_POSITION;
    }
}





