<?php

declare(strict_types=1);

namespace Octfx\Aoc23D4;

use RuntimeException;

/**
 * Parses an input file into a card pile containing cards
 */
class FileParser
{
    private string $filePath;

    /**
     * @param string $path Path to the input.txt
     */
    public function __construct(string $path)
    {
        $this->filePath = $path;
    }

    /**
     * @return CardPile
     */
    public function getCardPile(): CardPile {
        if (!file_exists($this->filePath)) {
            throw new RuntimeException(sprintf('Input file "%s" does not exist.', $this->filePath));
        }

        $content = file_get_contents($this->filePath);

        if (!is_string($content) || strlen($content) === 0) {
            throw new RuntimeException(sprintf('Could not read content of file "%s".', $this->filePath));
        }

        $pile = new CardPile();

        foreach (explode("\n", $content) as $line) {
            if (strlen($line) === 0) {
                continue;
            }
            $pile->addCard(Card::newFromLine($line));
        }

        return $pile;
    }
}