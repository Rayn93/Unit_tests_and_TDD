<?php

namespace Test\Makao\Collection;

use Makao\Card;
use Makao\Collection\CardCollection;
use Makao\Exception\CardNotFoundException;
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

}