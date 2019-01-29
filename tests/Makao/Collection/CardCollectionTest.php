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
        $this->cardCollection->addCard(new Card);

        //Then
        $this->assertCount(1, $this->cardCollection);

    }

    public function testShouldAddCartsInChain()
    {
        //When
        $this->cardCollection
            ->addCard(new Card)
            ->addCard(new Card);

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
        //Expect


        //Given
        $card = new Card();

        //When //Then
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
        $firstCard = new Card();
        $secondCard = new Card();
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
        $firstCard = new Card();
        $secondCard = new Card();
        $this->cardCollection
            ->addCard($firstCard)
            ->addCard($secondCard);

        //When
        $this->cardCollection->pickCard();
        $this->cardCollection->pickCard();
        $this->cardCollection->pickCard();

        //Then
    }

    public function testShouldThrowMethodNotAllowExceptionWhenYouTryAddCardToColletionAsArray()
    {
        //Expect
        $this->expectException(MethodNotAllowException::class);
        $this->expectExceptionMessage('You can not add card to collection as Array. Use addCard method');

        //Given
        $card = new Card;

        //When
        $this->cardCollection[] = $card;

        //Then


    }

}