<?php

declare(strict_types=1);

namespace Octfx\Aoc23D4\Tests;

use InvalidArgumentException;
use Octfx\Aoc23D4\Card;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
    /**
     * @covers \Octfx\Aoc23D4\Card::newFromLine
     * @return void
     */
    public function testNewFromLineInvalid(): void {
        $this->expectException(InvalidArgumentException::class);

        Card::newFromLine('foo');
    }

    /**
     * @covers \Octfx\Aoc23D4\Card::newFromLine
     * @return void
     */
    public function testNewFromLine(): void {
        $card = Card::newFromLine('Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53');

        $this->assertEquals(1, $card->id);
        $this->assertCount(5, $card->numWinning);
        $this->assertCount(8, $card->numHave);
    }

    /**
     * @covers \Octfx\Aoc23D4\Card::newFromLine
     * @covers \Octfx\Aoc23D4\Card::getWinningNumberCount
     * @return void
     */
    public function testGetCountOfWinningNumbers(): void {
        $card = Card::newFromLine('Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53');

        $this->assertEquals(5, $card->getWinningNumberCount());
    }

    /**
     * @covers \Octfx\Aoc23D4\Card::newFromLine
     * @covers \Octfx\Aoc23D4\Card::getPoints
     * @return void
     */
    public function testCalculatePuzzle1Points(): void {
        $card = Card::newFromLine('Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53');

        $this->assertEquals(8, $card->getPoints());
    }
}