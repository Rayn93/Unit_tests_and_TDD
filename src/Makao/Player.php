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

    public function getCard()
    {
        return $this->cardCollection;
    }
}