<?php
namespace Makao;

use Makao\Collection\CardCollection;

class Player
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var CardCollection
     */
    private $cardCollection;


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

    public function pickCard() : Card
    {
        return $this->getCards()->pickCard();
    }

    public function takeCard(CardCollection $cardCollection) : self
    {
        $this->cardCollection->addCard($cardCollection->pickCard());

        return $this;
    }
}
