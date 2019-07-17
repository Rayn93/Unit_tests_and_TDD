<?php

namespace Test\Makao;

use Makao\Card;
use Makao\Collection\CardCollection;
use Makao\Exception\CardNotFoundException;
use Makao\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testShouldWritePayerName() : void
    {
        //Given
        $player = new Player('Rob');

        //When
        ob_start();
        echo $player;
        $actual = ob_get_clean();

        //Then
        $this->assertEquals($actual, 'Rob');
    }
    
    public function testShouldReturnPlayerCardCollection() : void
    {
        //Given
        $cardCollection = new CardCollection([new Card(Card::COLOR_HEART, Card::VALUE_ACE)]);
        $player = new Player('Andy', $cardCollection);

        //When
        $actual = $player->getCards();

        //Then
        $this->assertEquals($cardCollection, $actual);
    }

    public function testShouldAllowPlayerTakeCardFromDeck() : void
    {
        //Given
        $card = new Card(Card::COLOR_HEART, Card::VALUE_ACE);
        $cardCollection = new CardCollection([$card]);
        $player = new Player('Andy');

        //When
        $actual = $player->takeCards($cardCollection)->getCards();

        //Then
        $this->assertCount(0, $cardCollection);
        $this->assertCount(1, $actual);
        $this->assertEquals($card, $actual[0]);
    }

    public function testShouldAllowPlayerTakeManyCardsFromDeck() : void
    {
        //Given
        $card1 = new Card(Card::COLOR_HEART, Card::VALUE_ACE);
        $card2 = new Card(Card::COLOR_CLUB, Card::VALUE_TEN);
        $card3 = new Card(Card::COLOR_DIAMOND, Card::VALUE_FIVE);

        $cardCollection = new CardCollection([$card1, $card2, $card3]);
        $player = new Player('Andy');

        //When
        $actual = $player->takeCards($cardCollection, 2)->getCards();

        //Then
        $this->assertCount(1, $cardCollection);
        $this->assertCount(2, $actual);
        $this->assertEquals($card1, $actual->pickCard());
        $this->assertEquals($card3, $cardCollection->pickCard());
    }
    
    public function testShouldAllowPickChosenCardFromPlayerCardCollection()
    {
        //Given
        $card1 = new Card(Card::COLOR_HEART, Card::VALUE_ACE);
        $card2 = new Card(Card::COLOR_CLUB, Card::VALUE_TEN);
        $card3 = new Card(Card::COLOR_DIAMOND, Card::VALUE_FIVE);
        $cardCollection = new CardCollection([$card1, $card2, $card3]);
        $player = new Player('Andy', $cardCollection);

        //When
        $actual = $player->pickCard(2);
    
        //Then
        $this->assertSame($card3, $actual);
    }

    public function testShouldAllowPlayerSayMakao() : void
    {
        //Given
        $player = new Player('Andy');

        //When
        $actual = $player->sayMakao();

        //Then
        $this->assertEquals('Makao', $actual);
    }
    
    public function testShouldThrowCardNotFoundExceptionWhenPlayerTryPickCardByValueAndHasNotCorrectCardInHand()
    {
        //Expect
        $this->expectException(CardNotFoundException::class);
        $this->expectExceptionMessage('Player has not card with value 2');
    
        //Given
        $player = new Player('Andy');
    
        //When
        $player->pickCardByValue(Card::VALUE_TWO);
    }
    
    public function testShouldReturnPickCardByValueWhenPlayerHasCorrectCard()
    {
        //Given
        $player = new Player('Andy');

        //When
        $player->pickCardByValue(Card::VALUE_TWO);
    }
}
