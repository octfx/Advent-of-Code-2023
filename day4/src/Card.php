<?php

declare(strict_types=1);

namespace Octfx\Aoc23D4;

use InvalidArgumentException;

/**
 * A Card containing winning numbers and numbers
 */
class Card
{
    /**
     * @var int Card ID
     */
    public readonly int $id;

    /**
     * @var array List of winning numbers
     */
    public readonly array $numWinning;

    /**
     * @var array List of numbers contained on the card
     */
    public readonly array $numHave;

    /**
     * @var int|null Count of winning numbers on this card
     */
    private ?int $winningNumberCount = null;

    /**
     * @param int $id
     * @param array $winning
     * @param array $have
     */
    private function __construct(int $id, array $winning, array $have)
    {
        $this->id = $id;
        $this->numWinning = $winning;
        $this->numHave = $have;
    }

    /**
     * Calculate the count of numbers contained in the winning numbers set
     *
     * @return int
     */
    public function getWinningNumberCount(): int {
        if ($this->winningNumberCount !== null) {
            return $this->winningNumberCount;
        }

        $this->winningNumberCount = count(array_intersect($this->numHave, $this->numWinning));

        return $this->winningNumberCount;
    }

    /**
     * Calculates the points of a card for puzzle 1
     *
     * @return int
     */
    public function getPoints(): int {
        $intersection = $this->getWinningNumberCount() - 1;

        if ($intersection === -1) {
            return 0;
        }

        return 2**$intersection;
    }

    /**
     * Get a card instance from a game line
     *
     * @param string $line
     * @return self
     * @throws InvalidArgumentException
     */
    public static function newFromLine(string $line): self {
        if (!preg_match('/Card\s+\d+:\s*(?:\d+\s+)+\|\s+(?:\d+\s*)+/', $line)) {
            throw new InvalidArgumentException('Line does not match expected format. ' . $line);
        }

        [0 => $part1, 1 => $have] = explode('|', $line);

        [0 => $id, 1 => $winning] = explode(':', $part1);

        $fn = fn (string $num) => (int)trim($num);

        $winning = array_filter(array_map($fn, explode(' ', $winning)));
        $have = array_filter(array_map($fn, explode(' ', $have)));
        $id = (int)str_replace('Card ', '', $id);

        return new self($id, $winning, $have);
    }

    public function __toString(): string
    {
        return sprintf('Card %d: Worth %d points.', $this->id, $this->getPoints());
    }
}