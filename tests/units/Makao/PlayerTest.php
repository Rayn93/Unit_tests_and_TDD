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
        $card = new Card(Card::COLOR_HEART, Card::VALUE_TWO);
        $player = new Player('Andy', new CardCollection([
            $card,
            new Card(Card::COLOR_SPADE, Card::VALUE_TWO)
        ]));

        //When
        $actual = $player->pickCardByValue(Card::VALUE_TWO);

        //Then
        $this->assertSame($card, $actual);
    }

    public function testShouldReturnTrueWhenPlayerCanPlayRound()
    {
        //Given
        $player = new Player('Andy');

        //Then
        $this->assertTrue($player->canPlayRound());
    }

    public function testShouldReturnFalseWhenPlayerCanNotPlayRound()
    {
        //Given
        $player = new Player('Andy');

        //When
        $player->addRoundToSkip();

        //Then
        $this->assertFalse($player->canPlayRound());
    }

    public function testShouldSkipManyRoundAndBackToPlayAfter()
    {
        //Given
        $player = new Player('Andy');

        //When
        $this->assertTrue($player->canPlayRound());

        $player->addRoundToSkip(2);
        $this->assertFalse($player->canPlayRound());
        $this->assertSame(2, $player->getRoundToSkip());

        $player->skipRound();
        $this->assertFalse($player->canPlayRound());
        $this->assertSame(1, $player->getRoundToSkip());

        $player->skipRound();
        $this->assertTrue($player->canPlayRound());
        $this->assertSame(0, $player->getRoundToSkip());
    }

    public function testShouldThrowCardNotFoundExceptionWhenPlayerTryPickCardsByValueAndHasNotCorrectCardInHand()
    {
        //Expect
        $this->expectException(CardNotFoundException::class);
        $this->expectExceptionMessage('Player has not card with value 2');

        //Given
        $player = new Player('Andy');

        //When
        $player->pickCardsByValue(Card::VALUE_TWO);
    }

    public function testShouldReturnPickCardsByValueWhenPlayerHasCorrectCard()
    {
        //Given
        $cardCollection = new CardCollection([
            new Card(Card::COLOR_HEART, Card::VALUE_TWO),
        ]);

        $player = new Player('Andy', clone $cardCollection);

        //When
        $actual = $player->pickCardsByValue(Card::VALUE_TWO);

        //Then
        $this->assertEquals($cardCollection, $actual);
    }

    public function testShouldReturnPickCardsByValueWhenPlayerHasMoreCorrectCard()
    {
        //Given
        $cardCollection = new CardCollection([
            new Card(Card::COLOR_HEART, Card::VALUE_TWO),
            new Card(Card::COLOR_DIAMOND, Card::VALUE_TWO),
        ]);

        $player = new Player('Andy', clone $cardCollection);

        //When
        $actual = $player->pickCardsByValue(Card::VALUE_TWO);

        //Then
        $this->assertEquals($cardCollection, $actual);
    }
}
