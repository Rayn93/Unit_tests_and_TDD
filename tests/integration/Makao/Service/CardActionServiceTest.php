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

    public function testShouldGiveFirstPlayerSixCardsWhenCardTwoWasDroppedAndSecondAndThirdPlayerHasCardsTwoToDefend() : void
    {
        //Given
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_TWO);

        $this->player2->getCards()->addCard(new Card(Card::COLOR_HEART, Card::VALUE_TWO));
        $this->player3->getCards()->addCard(new Card(Card::COLOR_CLUB, Card::VALUE_TWO));

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(0, $this->player2->getCards());
        $this->assertCount(0, $this->player3->getCards());
        $this->assertCount(6, $this->player1->getCards());
        $this->assertSame($this->player2, $this->table->getCurrentPlayer());
    }

    public function testShouldGiveSecondPlayerEightCardsWhenCardTwoWasDroppedAndAllPlayersHasCardsTwoToDefend() : void
    {
        //Given
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_TWO);

        $this->player1->getCards()->addCard(new Card(Card::COLOR_DIAMOND, Card::VALUE_TWO));
        $this->player2->getCards()->addCard(new Card(Card::COLOR_HEART, Card::VALUE_TWO));
        $this->player3->getCards()->addCard(new Card(Card::COLOR_CLUB, Card::VALUE_TWO));

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(8, $this->player2->getCards());
        $this->assertCount(0, $this->player3->getCards());
        $this->assertCount(0, $this->player1->getCards());
        $this->assertSame($this->player3, $this->table->getCurrentPlayer());
    }

    public function testShouldGiveNextPlayerThreeCardsWhenCardThreeWasDropped()
    {
        //Given
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_THREE);

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(3, $this->player2->getCards());
        $this->assertSame($this->player3, $this->table->getCurrentPlayer());
    }

    public function testShouldGiveThirdPlayerSixCardsWhenCardThreeWasDroppedAndSecondPlayerHasCardThreeToDefend() : void
    {
        //Given
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_THREE);

        $this->player2->getCards()->addCard(new Card(Card::COLOR_HEART, Card::VALUE_THREE));

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(0, $this->player2->getCards());
        $this->assertCount(6, $this->player3->getCards());
        $this->assertSame($this->player1, $this->table->getCurrentPlayer());
    }

    public function testShouldGiveFirstPlayerNineCardsWhenCardThreeWasDroppedAndSecondAndThirdPlayerHasCardsThreeToDefend() : void
    {
        //Given
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_THREE);

        $this->player2->getCards()->addCard(new Card(Card::COLOR_HEART, Card::VALUE_THREE));
        $this->player3->getCards()->addCard(new Card(Card::COLOR_CLUB, Card::VALUE_THREE));

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(0, $this->player2->getCards());
        $this->assertCount(0, $this->player3->getCards());
        $this->assertCount(9, $this->player1->getCards());
        $this->assertSame($this->player2, $this->table->getCurrentPlayer());
    }
    
    public function testShouldShipRoundForNextPlayerWhenCardFourWasDropped()
    {
        //Given
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_FOUR);
    
        //When
        $this->cardActionServiceUnderTest->afterCard($card);
    
        //Then
        $this->assertSame($this->player3, $this->table->getCurrentPlayer());
    }

    public function testShouldShipManyRoundForNextPlayerWhenCardFourWasDroppedAndNextPlayerHasCardToDefend()
    {
        //Given
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_FOUR);

        $this->player2->getCards()->addCard(new Card(Card::COLOR_HEART, Card::VALUE_FOUR));
        $this->player3->getCards()->addCard(new Card(Card::COLOR_CLUB, Card::VALUE_FOUR));

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertSame($this->player2, $this->table->getCurrentPlayer());
        $this->assertEquals(2, $this->player1->getRoundToSkip());
        $this->assertFalse($this->player1->canPlayRound());
        $this->assertTrue($this->player2->canPlayRound());
        $this->assertTrue($this->player3->canPlayRound());
    }

    public function testShouldRequestCardByValueWhenCardJackWasDroppedAndTakeCardForEachPlayerWhenThayNotHaveRequestedCard()
    {
        //Given
        $requestedValue = Card::VALUE_SEVEN;
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_JACK);

        $requestedCard = new Card(Card::COLOR_SPADE, Card::VALUE_SEVEN);
        $this->player1->getCards()->addCard($requestedCard);

        //When
        $this->cardActionServiceUnderTest->afterCard($card, $requestedValue);

        //Then
        $this->assertCount(0, $this->player1->getCards());
        $this->assertCount(1, $this->player2->getCards());
        $this->assertCount(1, $this->player3->getCards());
        $this->assertSame($requestedCard, $this->table->getPlayedCards()->getLastCard());
        $this->assertSame($this->player2, $this->table->getCurrentPlayer());
    }

    public function testShouldRequestCardByValueWhenCardJackWasDroppedAndPickCardForEachPlayerWhenThayHaveRequestedCard()
    {
        //Given
        $requestedValue = Card::VALUE_SEVEN;
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_JACK);

        $this->player1->getCards()->addCard(new Card(Card::COLOR_SPADE, Card::VALUE_SEVEN));
        $this->player2->getCards()->addCard(new Card(Card::COLOR_HEART, Card::VALUE_SEVEN));
        $this->player3->getCards()->addCard(new Card(Card::COLOR_DIAMOND, Card::VALUE_SEVEN));

        //When
        $this->cardActionServiceUnderTest->afterCard($card, $requestedValue);

        //Then
        $this->assertCount(0, $this->player1->getCards());
        $this->assertCount(0, $this->player2->getCards());
        $this->assertCount(0, $this->player3->getCards());
        $this->assertSame($this->player2, $this->table->getCurrentPlayer());
    }

    public function testShouldAllowDropManyRequestedCardsByValueWhenPlayerDropJackCard()
    {
        //Given
        $requestedValue = Card::VALUE_SEVEN;
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_JACK);
        $requestedCard = new Card(Card::COLOR_SPADE, Card::VALUE_SEVEN);

        $this->player1->getCards()->addCard(new Card(Card::COLOR_DIAMOND, Card::VALUE_SEVEN));
        $this->player1->getCards()->addCard(new Card(Card::COLOR_HEART, Card::VALUE_SEVEN));
        $this->player1->getCards()->addCard($requestedCard);

        //When
        $this->cardActionServiceUnderTest->afterCard($card, $requestedValue);

        //Then
        $this->assertCount(0, $this->player1->getCards());
        $this->assertCount(1, $this->player2->getCards());
        $this->assertCount(1, $this->player3->getCards());
        $this->assertSame($requestedCard, $this->table->getPlayedCards()->getLastCard());
        $this->assertSame($this->player2, $this->table->getCurrentPlayer());
    }

    public function testShouldGiveNextPlayerFiveCardsWhenCardKingHeartWasDropped()
    {
        //Given
        $card = new Card(Card::COLOR_HEART, Card::VALUE_KING);

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(5, $this->player2->getCards());
        $this->assertSame($this->player3, $this->table->getCurrentPlayer());
    }

    public function testShouldGivePreviousPlayerFiveCardsWhenCardKingSpadeWasDropped()
    {
        //Given
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_KING);

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(5, $this->player3->getCards());
        $this->assertSame($this->player1, $this->table->getCurrentPlayer());
    }

    public function testShouldGiveCurrntPlayerTenCardsWhenCardKingHeartWasDroppedAndNextPlayerHasKingSpadeToDefence()
    {
        //Given
        $card = new Card(Card::COLOR_HEART, Card::VALUE_KING);

        $this->player2->getCards()->addCard(new Card(Card::COLOR_SPADE, Card::VALUE_KING));

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(10, $this->player1->getCards());
        $this->assertSame($this->player2, $this->table->getCurrentPlayer());
    }

    public function testShouldGiveCurrntPlayerTenCardsWhenCardKingSpadeWasDroppedAndNextPlayerHasKingHeartToDefence()
    {
        //Given
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_KING);

        $this->player3->getCards()->addCard(new Card(Card::COLOR_HEART, Card::VALUE_KING));

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(10, $this->player1->getCards());
        $this->assertSame($this->player2, $this->table->getCurrentPlayer());
    }

    public function testShouldNotRunAnyActionForOtherKings()
    {
        //Given
        $card = new Card(Card::COLOR_DIAMOND, Card::VALUE_KING);

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(0, $this->player1->getCards());
        $this->assertCount(0, $this->player2->getCards());
        $this->assertCount(0, $this->player3->getCards());
        $this->assertSame($this->player2, $this->table->getCurrentPlayer());
    }

    public function testShouldNotRunAnyActionForAnyNoActionCard()
    {
        //Given
        $card = new Card(Card::COLOR_DIAMOND, Card::VALUE_FIVE);

        //When
        $this->cardActionServiceUnderTest->afterCard($card);

        //Then
        $this->assertCount(0, $this->player1->getCards());
        $this->assertCount(0, $this->player2->getCards());
        $this->assertCount(0, $this->player3->getCards());
        $this->assertSame($this->player2, $this->table->getCurrentPlayer());
    }
    
    public function testShouldChangeColorToPlayOnTableAfterCardAce()
    {
        //Given
        $requestColor = Card::COLOR_HEART;
        $card = new Card(Card::COLOR_SPADE, Card::VALUE_ACE);
    
        //When $ Then
        $this->assertEquals(Card::COLOR_SPADE, $this->table->getPlayedCardColor());
        $this->cardActionServiceUnderTest->afterCard($card, $requestColor);
        $this->assertEquals(Card::COLOR_HEART, $this->table->getPlayedCardColor());
    
        //

        
    }
}