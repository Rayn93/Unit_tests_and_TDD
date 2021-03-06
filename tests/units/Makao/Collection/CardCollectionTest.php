<?php

namespace Test\Makao\Collection;

use Makao\Card;
use Makao\Collection\CardCollection;
use Makao\Exception\CardNotFoundException;
use Makao\Exception\MethodNotAllowException;
use PHPUnit\Framework\TestCase;

class CardCollectionTest extends TestCase
{
    /** @var CardCollection */
    private $cardCollection;

    protected function setUp()
    {
        $this->cardCollection = new CardCollection();
    }

    public function testShouldReturnZeroOnEmptyCollection()
    {
        //When
        $this->assertCount(0, $this->cardCollection);
    }

    public function testShouldAddCartToCollection()
    {
        //When
        $this->cardCollection->addCard(new Card(Card::COLOR_CLUB, Card::VALUE_FIVE));

        //Then
        $this->assertCount(1, $this->cardCollection);
    }

    public function testShouldAddCartsInChain()
    {
        //When
        $this->cardCollection
            ->addCard(new Card(Card::COLOR_CLUB, Card::VALUE_FIVE))
            ->addCard(new Card(Card::COLOR_CLUB, Card::VALUE_ACE));

        //Then
        $this->assertCount(2, $this->cardCollection);
    }

    public function testShouldThrowCardNotFoundExceptionWhenPickCardFromEmptyCollection()
    {
        //Expect
        $this->expectException(CardNotFoundException::class);
        $this->expectExceptionMessage('Card collection is empty');

        //Given


        //When
        $this->cardCollection->pickCard();

        //Then
    }

    public function testShouldIterableOnCardCollection()
    {
        //Given
        $card = new Card(Card::COLOR_CLUB, Card::VALUE_FIVE);

        //When & Then
        $this->cardCollection->addCard($card);

        $this->assertSame($card, $this->cardCollection->current());
        $this->assertSame(0, $this->cardCollection->key());
        $this->assertTrue($this->cardCollection->valid());

        $this->cardCollection->next();
        $this->assertFalse($this->cardCollection->valid());
        $this->assertSame(1, $this->cardCollection->key());

        $this->cardCollection->rewind();

        $this->assertSame($card, $this->cardCollection->current());
        $this->assertSame(0, $this->cardCollection->key());
        $this->assertTrue($this->cardCollection->valid());
    }

    public function testShouldGetFirstCardFromCardsCollectionAndRemoveItFromDeck()
    {
        //When
        $firstCard = new Card(Card::COLOR_CLUB, Card::VALUE_FIVE);
        $secondCard = new Card(Card::COLOR_HEART, Card::VALUE_TEN);
        $this->cardCollection
            ->addCard($firstCard)
            ->addCard($secondCard);

        //Then
        $this->assertCount(2, $this->cardCollection);

        $actualCard = $this->cardCollection->pickCard();

        $this->assertCount(1, $this->cardCollection);
        $this->assertSame($firstCard, $actualCard);
        $this->assertSame($secondCard, $this->cardCollection[0]);
    }

    public function testShouldThrowCardNotFoundExceptionWhenPickMoreCardsThanInCollection()
    {
        //Expect
        $this->expectException(CardNotFoundException::class);
        $this->expectExceptionMessage('Card collection is empty');

        //Given
        $firstCard = new Card(Card::COLOR_CLUB, Card::VALUE_FIVE);
        $secondCard = new Card(Card::COLOR_HEART, Card::VALUE_TEN);
        $this->cardCollection
            ->addCard($firstCard)
            ->addCard($secondCard);

        //When
        $this->cardCollection->pickCard();
        $this->cardCollection->pickCard();
        $this->cardCollection->pickCard();
    }

    public function testShouldReturnChosenCardPickedFromCollection()
    {
        //Given
        $firstCard = new Card(Card::COLOR_CLUB, Card::VALUE_FIVE);
        $secondCard = new Card(Card::COLOR_HEART, Card::VALUE_TEN);
        $this->cardCollection
            ->addCard($firstCard)
            ->addCard($secondCard);

        //When
        $actual = $this->cardCollection->pickCard(1);

        //Then
        $this->assertSame($secondCard, $actual);
    }

    public function testShouldThrowMethodNotAllowExceptionWhenYouTryAddCardToColletionAsArray()
    {
        //Expect
        $this->expectException(MethodNotAllowException::class);
        $this->expectExceptionMessage('You can not add card to collection as Array. Use addCard() method');

        //Given
        $card = new Card(Card::COLOR_CLUB, Card::VALUE_FIVE);

        //When
        $this->cardCollection[] = $card;
    }

    public function testShuldReturnCollectionAsArray()
    {
        //Given
        $cards = [
            new Card(Card::COLOR_CLUB, Card::VALUE_FIVE),
            new Card(Card::COLOR_HEART, Card::VALUE_TEN),
        ];

        //When
        $actual = new CardCollection($cards);

        //Then
        $this->assertEquals($cards, $actual->toArray());
    }

    public function testShouldAddCardCollectionToCardCollection()
    {
        //Given
        $cardCollection = new CardCollection([
            new Card(Card::COLOR_SPADE, Card::VALUE_FIVE),
            new Card(Card::COLOR_DIAMOND, Card::VALUE_JACK),
        ]);

        //When
        $actual = $this->cardCollection->addCardCollection($cardCollection);

        //Then
        $this->assertEquals($cardCollection, $actual);
    }
    
    public function testShouldReturnLastCardFromCollectionWithoutPicking()
    {
        //Given
        $lastCard = new Card(Card::COLOR_DIAMOND, Card::VALUE_JACK);
        $cardCollection = new CardCollection([
            new Card(Card::COLOR_SPADE, Card::VALUE_FIVE),
            $lastCard,
        ]);
    
        //When
        $actual = $cardCollection->getLastCard();
    
        //Then
        $this->assertEquals($lastCard, $actual);
        $this->assertCount(2, $cardCollection);
    }

    public function testShouldThrowCardNotFoundExceptionWhenTryGetLastCardFromEmptyCollection()
    {
        //Expect
        $this->expectException(CardNotFoundException::class);
        $this->expectExceptionMessage('You can not get last card from empty collection');

        //Given
        $actual = $this->cardCollection->getLastCard();
    }
}
