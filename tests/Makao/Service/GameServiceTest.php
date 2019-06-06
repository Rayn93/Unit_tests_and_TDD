<?php
namespace Test\Makao\Service;

use Makao\Player;
use Makao\Service\GameService;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    /**
     * @var GameService
     */
    private $gameServiceUnderTest;

    public function setUp()
    {
        $this->gameServiceUnderTest = new GameService();
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
}