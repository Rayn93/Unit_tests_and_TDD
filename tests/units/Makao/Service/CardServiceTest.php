<?php
namespace Test\Makao\Service;

use Makao\Card;
use Makao\Collection\CardCollection;
use Makao\Service\CardService;
use Makao\Service\ShuffleService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CardServiceTest extends TestCase
{
    /** @var CardService */
    private $cardServiceUnderTest;

    /** @var MockObject | ShuffleService */
    private $shuffleServiceMock;

    public function setUp()
    {
        $this->shuffleServiceMock = $this->createMock(ShuffleService::class);
        $this->cardServiceUnderTest = new CardService($this->shuffleServiceMock);
    }

    public function testShouldAllowCreateNewCardCollection() : CardCollection
    {
        //When
        $actual = $this->cardServiceUnderTest->createDeck();

        //Then
        $this->assertInstanceOf(CardCollection::class, $actual);
        $this->assertCount(52, $actual);
        $i = 0;

        foreach (Card::values() as $value) {
            foreach (Card::colors() as $color) {
                $this->assertEquals($value, $actual[$i]->getValue());
                $this->assertEquals($color, $actual[$i]->getColor());
                $i++;
            }
        }

        return $actual;
    }

    /**
     * @depends testShouldAllowCreateNewCardCollection
     * @param CardCollection $cardCollection
     */
    public function testShouldShuffleCardsInCardCollection(CardCollection $cardCollection)
    {
        $this->shuffleServiceMock->expects($this->once())
            ->method('shuffle')
            ->willReturn(array_reverse($cardCollection->toArray()));

        //When
        $actual = $this->cardServiceUnderTest->shuffle($cardCollection);

        //Then
        $this->assertNotEquals($cardCollection, $actual);
        $this->assertEquals($cardCollection->pickCard(), $actual[51]);
    }
}