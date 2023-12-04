<?php

declare(strict_types=1);

namespace Octfx\Aoc23D4;

/**
 * A pile of cards
 */
class CardPile
{
    /**
     * @var Card[]
     */
    private array $cards = [];

    /**
     * Add a card to the pile
     *
     * @param Card $card
     * @return void
     */
    public function addCard(Card $card): void {
        $this->cards[$card->id] = $card;
    }

    /**
     * Calculate the points in this pile for puzzle 1
     *
     * @return int
     */
    public function getPoints(): int {
        return array_reduce($this->cards, fn (int $carry, Card $card) => $carry + $card->getPoints(), 0);
    }

    /**
     * Calculate the total number of scratch cards for puzzle 2
     *
     * @return int
     */
    public function getNumberOfScratchCards(): int {
        return array_reduce($this->cards, fn (int $carry, Card $card) => $carry + $this->getCopies($card), 0);
    }

    /**
     * Get the number of copies for a card recursively
     *
     * @param Card $card
     * @return int
     */
    private function getCopies(Card $card): int {
        $points = $card->getWinningNumberCount();

        if ($points === 0) {
            return 1;
        }

        return array_reduce(
            array_slice($this->cards, $card->id, $points),
            fn(int $carry, Card $card) => $carry + $this->getCopies($card),
            1
        );
    }

    /**
     * Get the cards in this pile
     *
     * @return Card[]
     */
    public function getCards(): array {
        return $this->cards;
    }

    public function __toString(): string
    {
        return sprintf('Pile containing %d cards, worth %d points.', count($this->cards), $this->getPoints());
    }
}