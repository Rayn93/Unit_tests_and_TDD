<?php
namespace Makao\Service;

use Makao\Card;
use Makao\Exception\CardNotFoundException;
use Makao\Player;
use Makao\Table;

class CardActionService
{
    /**
     * @var Table
     */
    private $table;
    private $cardToGet = 0;
    private $actionCount = 0;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function afterCard(Card $card) : void
    {
        $this->table->finishRound();

        switch ($card->getValue()) {
            case Card::VALUE_TWO:
                $this->takingCards(Card::VALUE_TWO, 2);
                break;
            case Card::VALUE_THREE:
                $this->takingCards(Card::VALUE_THREE, 3);
                break;
            case Card::VALUE_FOUR:
                $this->skipRound();
                break;
            default:
                break;
        }
    }

    private function takingCards(string $cardValue, int $cardsToGet) : void
    {
        $this->cardToGet += $cardsToGet;
        $player = $this->table->getCurrentPlayer();

        try {
            $card = $player->pickCardByValue($cardValue);
            $this->table->getPlayedCards()->addCard($card);
            $this->table->finishRound();
            $this->takingCards($cardValue, $cardsToGet);
        } catch (CardNotFoundException $e) {
            $this->playerTakeCards($this->cardToGet);
        }
    }

    private function playerTakeCards(int $count) : void
    {
        $this->table->getCurrentPlayer()->takeCards($this->table->getCardDeck(), $count);
        $this->table->finishRound();
    }

    private function skipRound() : void
    {
        ++$this->actionCount;
        $player = $this->table->getCurrentPlayer();

        try {
            $card = $player->pickCardByValue(Card::VALUE_FOUR);
            $this->table->getPlayedCards()->addCard($card);
            $this->table->finishRound();
            $this->skipRound();
        } catch (CardNotFoundException $e) {
            $player->addRoundToSkip($this->actionCount - 1);
            $this->table->finishRound();
        }
    }
}
