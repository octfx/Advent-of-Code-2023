<?php

declare(strict_types=1);

use Octfx\Aoc23D8\FileParser;

require_once './vendor/autoload.php';

$parser = new FileParser('./input.txt');

$map = $parser->getMap();

echo sprintf("Part 1: %d\nPart 2: %d\n", $map->getNumberOfSteps(), $map->part2());

