<?php

namespace Test\Makao;

use Makao\Card;
use Makao\Collection\CardCollection;
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
        $actual = $player->getCard();

        //Then
        $this->assertEquals($cardCollection, $actual);
    }
}
