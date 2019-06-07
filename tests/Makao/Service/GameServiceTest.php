<?php
namespace Test\Makao\Service;

use Makao\Card;
use Makao\Collection\CardCollection;
use Makao\Player;
use Makao\Service\CardService;
use Makao\Service\GameService;
use Makao\Table;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    /** @var GameService */
    private $gameServiceUnderTest;

    /** @var MockObject | CardService $cardServiceMock */
    private $cardServiceMock;

    public function setUp()
    {
        $this->cardServiceMock = $this->createMock(CardService::class);
        $this->gameServiceUnderTest = new GameService(new Table(), $this->cardServiceMock);
    }

    public function testShouldReturnFalseWhenGameIsNotStarted()
    {
        //When
        $actual = $this->gameServiceUnderTest->isStarted();

        //Then
        $this->assertFalse($actual);
    }
    
    public function testShouldInitNewGameWithEmptyTable()
    {
        //When
        $table = $this->gameServiceUnderTest->getTable();
    
        //Then
        $this->assertSame(0, $table->countPlayers());
        $this->assertCount(0, $table->getCardDeck());
        $this->assertCount(0, $table->getPlayedCards());
    }

    public function testShouldAddPlayersToTheTable()
    {
        //Given
        $players = [
            new Player('Andy'),
            new Player('Tomy'),
        ];

        //When
        $actual = $this->gameServiceUnderTest->addPlayers($players)->getTable();

        //Then
        $this->assertSame(2, $actual->countPlayers());
    }

    public function testShouldReturnTrueWhenGameIsStarted()
    {
        //When
        $this->gameServiceUnderTest->startGame();
        $actual = $this->gameServiceUnderTest->isStarted();

        //Then
        $this->assertTrue($actual);
    }

    public function testShouldCreateShuffledCardDeck()
    {
        //Given
        $cardCollection = new CardCollection([
            new Card(Card::COLOR_SPADE, Card::VALUE_FIVE),
            new Card(Card::COLOR_DIAMOND, Card::VALUE_JACK),
        ]);

        $shuffledCardCollection = new CardCollection([
            new Card(Card::COLOR_DIAMOND, Card::VALUE_JACK),
            new Card(Card::COLOR_SPADE, Card::VALUE_FIVE),
        ]);

        $this->cardServiceMock->expects($this->once())
            ->method('createDeck')
            ->willReturn($cardCollection);

        $this->cardServiceMock->expects($this->once())
            ->method('shuffle')
            ->with($cardCollection)
            ->willReturn($shuffledCardCollection);

        //When
        /** @var Table $table */
        $table = $this->gameServiceUnderTest->prepareCardDeck();

        //Then
        $this->assertCount(2, $table->getCardDeck());
        $this->assertCount(0, $table->getPlayedCards());
        $this->assertEquals($shuffledCardCollection, $table->getCardDeck());
    }
}
