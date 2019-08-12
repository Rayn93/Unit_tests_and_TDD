<?php
namespace Makao;

use Makao\Collection\CardCollection;
use Makao\Exception\ThrowTooManyPlayersAtTableException;

class Table
{
    private const MAX_PLAYERS = 4;
    private $players = [];
    public $currentIndexPlayer = 0;

    /**
     * @var CardCollection
     */
    private $cardDeck;

    /**
     * @var CardCollection
     */
    private $playedCards;


    public function __construct(CardCollection $cardDeck = null, CardCollection $playedCards = null)
    {
        $this->cardDeck = $cardDeck ?? new CardCollection();
        $this->playedCards = $playedCards ?? new CardCollection();
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

    public function getCurrentPlayer() : Player
    {
        return $this->players[$this->currentIndexPlayer];
    }

    public function getNextPlayer() : Player
    {
        return $this->players[$this->currentIndexPlayer + 1] ?? $this->players[0];
    }

    public function getPreviousPlayer() : Player
    {
        return $this->players[$this->currentIndexPlayer - 1] ?? $this->players[$this->countPlayers() - 1];
    }

    public function finishRound() : void
    {
        if (++$this->currentIndexPlayer === $this->countPlayers()) {
            $this->currentIndexPlayer = 0;
        }
    }

    public function backRound() : void
    {
        if (--$this->currentIndexPlayer < 0) {
            $this->currentIndexPlayer = $this->countPlayers() - 1;
        }
    }
}
