<?php
namespace Tests\Makao\Service;

use Makao\Card;
use Makao\Collection\CardCollection;
use Makao\Player;
use Makao\Service\CardActionService;
use Makao\Table;
use PHPUnit\Framework\TestCase;

class CardActionServiceTest extends TestCase
{
    public function testShouldGiveNextPlayerTwoCardsWhenCardTwoWasDropped()
    {
        //Given
        $playedCard = new CardCollection([
            new Card(Card::COLOR_SPADE, Card::VALUE_FIVE),
        ]);
        $deck = new CardCollection([
            new Card(Card::COLOR_SPADE, Card::VALUE_TEN),
            new Card(Card::COLOR_HEART, Card::VALUE_FIVE),
        ]);

        $player1 = new Player('Andy');
        $player2 = new Player('Bob');
        $player3 = new Player('Tom');

        $table = new Table($deck, $playedCard);
        $table->addPlayer($player1);
        $table->addPlayer($player2);
        $table->addPlayer($player3);

        $cardActionServiceUnderTest = new CardActionService($table);

        $card = new Card(Card::COLOR_SPADE, Card::VALUE_TWO);

        //When
        $cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(2, $player2->getCards());
        $this->assertSame($player3, $table->getCurrentPlayer());
    }

}