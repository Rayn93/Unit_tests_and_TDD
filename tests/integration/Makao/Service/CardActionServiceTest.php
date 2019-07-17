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
    /** @var Player */
    private $player1;

    /** @var Player */
    private $player2;

    /** @var Player */
    private $player3;

    /** @var Table */
    private $table;

    /** @var CardActionService*/
    private $cardActionServiceUnderTest;

    public function setUp()
    {
        //Given
        $playedCard = new CardCollection([
            new Card(Card::COLOR_SPADE, Card::VALUE_FIVE),
        ]);

        $deck = new CardCollection([
            new Card(Card::COLOR_SPADE, Card::VALUE_TEN),
            new Card(Card::COLOR_DIAMOND, Card::VALUE_SEVEN),
            new Card(Card::COLOR_SPADE, Card::VALUE_SIX),
            new Card(Card::COLOR_CLUB, Card::VALUE_FIVE),
            new Card(Card::COLOR_DIAMOND, Card::VALUE_EIGHT),
            new Card(Card::COLOR_HEART, Card::VALUE_FIVE),
            new Card(Card::COLOR_SPADE, Card::VALUE_TEN),
            new Card(Card::COLOR_DIAMOND, Card::VALUE_SEVEN),
            new Card(Card::COLOR_SPADE, Card::VALUE_SIX),
            new Card(Card::COLOR_CLUB, Card::VALUE_FIVE),
            new Card(Card::COLOR_DIAMOND, Card::VALUE_EIGHT),
            new Card(Card::COLOR_HEART, Card::VALUE_FIVE),
        ]);

        $this->player1 = new Player('Andy');
        $this->player2 = new Player('Bob');
        $this->player3 = new Player('Tom');

        $this->table = new Table($deck, $playedCard);
        $this->table->addPlayer($this->player1);
        $this->table->addPlayer($this->player2);
        $this->table->addPlayer($this->player3);

        $this->cardActionServiceUnderTest = new CardActionService($this->table);
    }


    public function testShouldGiveNextPlayerTwoCardsWhenCardTwoWasDropped()
    {
        //Given
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_TWO);

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(2, $this->player2->getCards());
        $this->assertSame($this->player3, $this->table->getCurrentPlayer());
    }

    public function testShouldGiveThirdPlayerFourCardsWhenCardTwoWasDroppedAndSecondPlayerHasCardTwoToDefend() : void
    {
        //Given
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_TWO);

        $this->player2->getCards()->addCard(new Card(Card::COLOR_HEART, Card::VALUE_TWO));

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(0, $this->player2->getCards());
        $this->assertCount(4, $this->player3->getCards());
        $this->assertSame($this->player1, $this->table->getCurrentPlayer());
    }

}