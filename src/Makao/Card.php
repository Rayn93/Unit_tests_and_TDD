<?php
namespace Makao;

class Card
{
    public const VALUE_TWO = '2';
    public const VALUE_THREE = '3';
    public const VALUE_FOUR = '4';
    public const VALUE_FIVE = '5';
    public const VALUE_SIX = '6';
    public const VALUE_SEVEN = '7';
    public const VALUE_EIGHT = '8';
    public const VALUE_NINE = '9';
    public const VALUE_TEN = '10';
    public const VALUE_JACK = 'jack';
    public const VALUE_QUEEN = 'queen';
    public const VALUE_KING = 'king';
    public const VALUE_ACE = 'ace';

    public const COLOR_DIAMOND = 'diamond';
    public const COLOR_SPADE = 'spade';
    public const COLOR_CLUB = 'club';
    public const COLOR_HEART = 'heart';

    private $color;
    private $value;

    public function __construct(string $color, string $value)
    {
        $this->color = $color;
        $this->value = $value;
    }

    public static function values() : array
    {
        return [
            self::VALUE_TWO,
            self::VALUE_THREE,
            self::VALUE_FOUR,
            self::VALUE_FIVE,
            self::VALUE_SIX,
            self::VALUE_SEVEN,
            self::VALUE_EIGHT,
            self::VALUE_NINE,
            self::VALUE_TEN,
            self::VALUE_JACK,
            self::VALUE_QUEEN,
            self::VALUE_KING,
            self::VALUE_ACE,
        ];
    }

    public static function colors() : array
    {
        return [
            self::COLOR_DIAMOND,
            self::COLOR_SPADE,
            self::COLOR_CLUB,
            self::COLOR_HEART,
        ];
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}