<?php
namespace Makao;

use Makao\Exception\ThrowTooManyPlayersAtTableException;

class Table
{
    private const MAX_PLAYERS = 4;
    private $players = [];

    public function countPlayers() : int
    {
        return count($this->players);
    }

    public function addPlayer(Player $player) : void
    {
        if($this->countPlayers() === self::MAX_PLAYERS) {
            throw new ThrowTooManyPlayersAtTableException(self::MAX_PLAYERS);
        }

        $this->players[] = $player;

    }
}