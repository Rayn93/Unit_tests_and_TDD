<?php
namespace Tests\Makao;

use Makao\Exception\ThrowTooManyPlayersAtTableException;
use Makao\Player;
use Makao\Table;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
    public function testShouldCreateEmptyTable()
    {
        //Given
        $tableUnderTest = new Table();

        //When
        $actual = $tableUnderTest->countPlayers();


        //Then
        $this->assertSame(0, $actual);
    }

    public function testShouldAddOnePlayerToTabel()
    {
        //Given
        $tableUnderTest = new Table();
        $player = new Player();

        //When
        $tableUnderTest->addPlayer($player);
        $actual = $tableUnderTest->countPlayers();

        //Then
        $this->assertSame(1, $actual);
    }

    public function testShouldReturnCountWhenIAddMannyPlayers()
    {
        //Given
        $tableUnderTest = new Table();

        //When
        $tableUnderTest->addPlayer(new Player());
        $tableUnderTest->addPlayer(new Player());
        $actual = $tableUnderTest->countPlayers();

        //Then
        $this->assertSame(2, $actual);
    }
    
    public function testShouldThrowTooManyPlayersAtTableExceptionWhenITryAddMoreThanFourPlayers()
    {
        //Expect
        $this->expectException(ThrowTooManyPlayersAtTableException::class);
        $this->expectExceptionMessage('Max capacity is 4 players!');

        //Given
        $tableUnderTest = new Table();

        //When
        $tableUnderTest->addPlayer(new Player());
        $tableUnderTest->addPlayer(new Player());
        $tableUnderTest->addPlayer(new Player());
        $tableUnderTest->addPlayer(new Player());
        $tableUnderTest->addPlayer(new Player());
    }
}