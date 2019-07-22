<?php
namespace Makao;

use Makao\Collection\CardCollection;
use Makao\Exception\CardNotFoundException;

class Player
{
    private const MAKAO = 'Makao';

    /**
     * @var string
     */
    private $name;

    /**
     * @var CardCollection
     */
    private $cardCollection;
    private $roundToSkip = 0;


    public function __construct($name, CardCollection $cardCollection = null)
    {
        $this->name = $name;
        $this->cardCollection = $cardCollection ?? new CardCollection();
    }

    public function __toString() : string
    {
        return $this->name;
    }

    public function getCards() : CardCollection
    {
        return $this->cardCollection;
    }

    public function pickCard(int $cardIndex = 0) : Card
    {
        return $this->getCards()->pickCard($cardIndex);
    }

    public function takeCards(CardCollection $cardCollection, int $count = 1) : self
    {
        for ($i = 0; $i < $count; $i++) {
            $this->cardCollection->addCard($cardCollection->pickCard());
        }

        return $this;
    }

    public function sayMakao() : string
    {
        return self::MAKAO;
    }

    public function pickCardByValue(string $value)
    {
        foreach ($this->cardCollection as $index => $card) {
            if ($card->getValue() === $value) {
                return $this->pickCard($index);
            }
        }

        throw new CardNotFoundException("Player has not card with value 2");
    }

    public function getRoundToSkip() : int
    {
        return $this->roundToSkip;
    }

    public function canPlayRound() : bool
    {
        return $this->roundToSkip === 0;
    }

    public function addRoundToSkip(int $rounds = 1) : self
    {
        $this->roundToSkip += $rounds;

        return $this;
    }

    public function skipRound() : self
    {
        --$this->roundToSkip;

        return $this;
    }
}
