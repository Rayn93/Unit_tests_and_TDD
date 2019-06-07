<?php
namespace Makao;

use Makao\Collection\CardCollection;
use Makao\Exception\ThrowTooManyPlayersAtTableException;

class Table
{
    private const MAX_PLAYERS = 4;
    private $players = [];

    /**
     * @var CardCollection
     */
    private $cardDeck;

    /**
     * @var CardCollection
     */
    private $playedCards;


    public function __construct(CardCollection $cardDeck = null)
    {
        $this->cardDeck = $cardDeck ?? new CardCollection();
        $this->playedCards = new CardCollection();
    }

    public function countPlayers() : int
    {
        return count($this->players);
    }

    public function addPlayer(Player $player) : void
    {
        if ($this->countPlayers() === self::MAX_PLAYERS) {
            throw new ThrowTooManyPlayersAtTableException(self::MAX_PLAYERS);
        }

        $this->players[] = $player;
    }

    public function getPlayedCards() : CardCollection
    {
        return $this->playedCards;
    }

    public function getCardDeck() : CardCollection
    {
        return $this->cardDeck;
    }

    public function addCardCollectionToDeck(CardCollection $cardCollection) : self
    {
        $this->cardDeck->addCardCollection($cardCollection);

        return $this;
    }
}
