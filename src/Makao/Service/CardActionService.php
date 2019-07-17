<?php
namespace Makao\Service;

use Makao\Card;
use Makao\Exception\CardNotFoundException;
use Makao\Table;

class CardActionService
{
    /**
     * @var Table
     */
    private $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function afterCard(Card $card) : void
    {
        $this->table->finishRound();

        switch ($card->getValue()) {
            case Card::VALUE_TWO:
                $this->cardTwoAction();
                break;
            default:
                break;
        }
    }

    private function cardTwoAction() : void
    {
        $player = $this->table->getCurrentPlayer();

        try {
            $card = $player->pickCardByValue(CARD::VALUE_TWO);
        } catch (CardNotFoundException $e) {
            $this->table->getCurrentPlayer()->takeCards($this->table->getCardDeck(), 2);
            $this->table->finishRound();
        }
    }
}
