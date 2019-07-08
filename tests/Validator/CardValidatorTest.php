<?php
namespace Tests\Makao\Validator;

use Makao\Card;
use Makao\Validator\CardValidator;
use PHPUnit\Framework\TestCase;

class CardValidatorTest extends TestCase
{
    public function cardsProvider() : array
    {
        return [
            'Return True When Valid Cards With The Same Colors' => [
                new Card(Card::COLOR_SPADE, Card::VALUE_FIVE),
                new Card(Card::COLOR_SPADE, Card::VALUE_JACK),
                true
            ],
            'Return False When Valid Cards With Different Colors or Values' => [
                new Card(Card::COLOR_SPADE, Card::VALUE_FIVE),
                new Card(Card::COLOR_HEART, Card::VALUE_JACK),
                false
            ],
            'Return True When Valid Cards With The Same Values' => [
                new Card(Card::COLOR_SPADE, Card::VALUE_FIVE),
                new Card(Card::COLOR_HEART, Card::VALUE_FIVE),
                true
            ],
        ];
    }

    /**
     * @dataProvider cardsProvider
     *
     * @param Card $activeCard
     * @param Card $newCard
     * @param bool $excepted
     */
    public function testShoulValidCards(Card $activeCard, Card $newCard, bool $excepted)
    {
        //Given
        $cardValidator = new CardValidator();

        //When
        $actual = $cardValidator->valid($activeCard, $newCard);

        //Then
        $this->assertSame($excepted, $actual);
    }
}
