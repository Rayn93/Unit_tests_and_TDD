<?php
namespace Tests\Makao;

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
        $player = new Player();

        //When
        $this->tableUnderTest->addPlayer($player);
        $actual = $this->tableUnderTest->countPlayers();

        //Then
        $this->assertSame(1, $actual);
    }

    public function testShouldReturnCountWhenIAddMannyPlayers() : void
    {
        //When
        $this->tableUnderTest->addPlayer(new Player());
        $this->tableUnderTest->addPlayer(new Player());
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
        $this->tableUnderTest->addPlayer(new Player());
        $this->tableUnderTest->addPlayer(new Player());
        $this->tableUnderTest->addPlayer(new Player());
        $this->tableUnderTest->addPlayer(new Player());
        $this->tableUnderTest->addPlayer(new Player());
    }
}