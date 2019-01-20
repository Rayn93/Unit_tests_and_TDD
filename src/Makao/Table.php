<?php
namespace Makao;

use Makao\Exception\ThrowTooManyPlayersAtTableException;

class Table
{
    private $players = [];

    public function countPlayers() : int
    {
        return count($this->players);
    }

    public function addPlayer(Player $player) : void
    {
        if($this->countPlayers() == 4) {
            throw new ThrowTooManyPlayersAtTableException('Max capacity is 4 players!');
        }

        $this->players[] = $player;

    }
}