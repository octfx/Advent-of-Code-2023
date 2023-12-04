<?php

declare(strict_types=1);

namespace Octfx\Aoc23D4\Tests;

use Octfx\Aoc23D4\FileParser;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class FileParserTest extends TestCase
{
    /**
     * @covers \Octfx\Aoc23D4\FileParser::getCardPile
     *
     * @return void
     */
    public function testParseMissingFile(): void {
        $this->expectException(RuntimeException::class);
        $parser = new FileParser('void');
        $parser->getCardPile();
    }

    /**
     * @covers \Octfx\Aoc23D4\FileParser::getCardPile
     *
     * @return void
     */
    public function testReadDir(): void {
        $this->expectException(RuntimeException::class);
        $parser = new FileParser('../src');
        $parser->getCardPile();
    }

    /**
     * @covers \Octfx\Aoc23D4\FileParser::getCardPile
     * @covers \Octfx\Aoc23D4\Card::newFromLine
     * @covers \Octfx\Aoc23D4\CardPile::addCard
     * @covers \Octfx\Aoc23D4\CardPile::getCards
     *
     * @return void
     */
    public function testParse(): void {
        $parser = new FileParser('./example.txt');
        $pile = $parser->getCardPile();

        $this->assertCount(6, $pile->getCards());
    }
}