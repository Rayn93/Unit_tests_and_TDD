<?php
namespace Tests\Makao;

use Makao\Card;
use Makao\Collection\CardCollection;
use Makao\Exception\ThrowTooManyPlayersAtTableException;
use Makao\Player;
use Makao\Table;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{

    /**
     * @var Table
     */
    private $tableUnderTest;

    public function setUp()
    {
        $this->tableUnderTest = new Table();
    }


    public function testShouldCreateEmptyTable() : void
    {
        //When
        $actual = $this->tableUnderTest->countPlayers();

        //Then
        $this->assertSame(0, $actual);
    }

    public function testShouldAddOnePlayerToTable() :void
    {
        //Given
        $player = new Player('Rob');

        //When
        $this->tableUnderTest->addPlayer($player);
        $actual = $this->tableUnderTest->countPlayers();

        //Then
        $this->assertSame(1, $actual);
    }

    public function testShouldReturnCountWhenIAddMannyPlayers() : void
    {
        //When
        $this->tableUnderTest->addPlayer(new Player('Rob'));
        $this->tableUnderTest->addPlayer(new Player('Tom'));
        $actual = $this->tableUnderTest->countPlayers();

        //Then
        $this->assertSame(2, $actual);
    }
    
    public function testShouldThrowTooManyPlayersAtTableExceptionWhenITryAddMoreThanFourPlayers() : void
    {
        //Expect
        $this->expectException(ThrowTooManyPlayersAtTableException::class);
        $this->expectExceptionMessage('Max capacity is 4 players!');

        //Given
        $this->tableUnderTest = new Table();

        //When
        $this->tableUnderTest->addPlayer(new Player('Rob'));
        $this->tableUnderTest->addPlayer(new Player('Andy'));
        $this->tableUnderTest->addPlayer(new Player('Max'));
        $this->tableUnderTest->addPlayer(new Player('John'));
        $this->tableUnderTest->addPlayer(new Player('Allen'));
    }
    
    public function testShouldReturnEmptyCardCollectionForPlayedCard()
    {
        //When
        $actual = $this->tableUnderTest->getPlayedCards();
    
        //Then
        $this->assertInstanceOf(CardCollection::class, $actual);
    }

    public function testShouldPutCardDeckOnTable()
    {
        //Given
        $cards = new CardCollection([new Card(Card::COLOR_CLUB, Card::VALUE_FIVE)]);

        //When
        $table = new Table($cards);
        $actual = $table->getCardDeck();


        //Then
        $this->assertSame($cards, $actual);
    }

    public function testShouldAddCardCollectionToCardDeckOnTable()
    {
        //Given
        $cardCollection = new CardCollection([
            new Card(Card::COLOR_SPADE, Card::VALUE_FIVE),
            new Card(Card::COLOR_DIAMOND, Card::VALUE_JACK),
        ]);

        //When
        $actual = $this->tableUnderTest->addCardCollectionToDeck($cardCollection);

        //Then
        $this->assertEquals($cardCollection, $actual->getCardDeck());

    }
}
