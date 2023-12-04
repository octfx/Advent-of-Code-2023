<?php

declare(strict_types=1);

namespace Octfx\Aoc23D4\Tests;

use Octfx\Aoc23D4\Card;
use Octfx\Aoc23D4\CardPile;
use PHPUnit\Framework\TestCase;

class CardPileTest extends TestCase
{
    /**
     * @covers \Octfx\Aoc23D4\CardPile::addCard
     * @covers \Octfx\Aoc23D4\CardPile::getCards
     * @return void
     */
    public function testAddCard(): void {
        $pile = new CardPile();
        $card = Card::newFromLine('Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53');

        $pile->addCard($card);

        $this->assertCount(1, $pile->getCards());
    }
}