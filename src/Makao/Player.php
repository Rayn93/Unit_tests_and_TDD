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

    public function pickCardByValue(string $value) : Card
    {
        return $this->pickCardByValueAndColor($value);
    }

    public function pickCardsByValue(string $cardValue) : CardCollection
    {
        $collection = new CardCollection();

        try {
            while ($card = $this->pickCardByValue($cardValue)) {
                $collection->addCard($card);
            }
        } catch (CardNotFoundException $e) {
            if (0 === $collection->count()) {
                throw $e;
            }
        }

        return $collection;
    }

    public function pickCardByValueAndColor(string $value, string $color = null) : Card
    {
        foreach ($this->cardCollection as $index => $card) {
            if ($card->getValue() === $value && ($color === null || $color === $card->getColor())) {
                return $this->pickCard($index);
            }
        }

        $message = 'Player has not card with value ' . $value;

        if ($color !== null) {
            $message .= ' and color ' . $color;
        }

        throw new CardNotFoundException($message);
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
