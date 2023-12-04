<?php

declare(strict_types=1);

use Octfx\Aoc23D4\FileParser;

require_once './vendor/autoload.php';

$parser = new FileParser('./input.txt');

$pile = $parser->getCardPile();

echo "Answer Puzzle 1: {$pile->getPoints()}\n";
echo "Answer Puzzle 2: {$pile->getNumberOfScratchCards()}\n";
