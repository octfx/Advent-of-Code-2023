<?php

declare( strict_types=1 );

namespace Octfx\Aoc23D8;


class Map {
	private readonly string $directions;
	private readonly int $directionLen;
	private readonly array $nodes;

	private int $counter = 0;

	public function __construct( string $directions, array $nodes ) {
		$this->directions = $directions;
		$this->directionLen = strlen( $directions );
		$this->nodes = $nodes;
	}

	public function getNumberOfSteps( string $start = 'AAA', int $moves = 0 ): int {
		do {
			$start = $this->nodes[$start][$this->getNextMoveIndex()];

			++ $moves;
		} while ( $start[2] !== 'Z' );

		return $moves;
	}

	private function getNextMoveIndex(): int {
		$move = $this->directions[$this->counter] === 'L' ? 0 : 1;

		$this->counter = ( $this->counter + 1 ) % $this->directionLen;

		return $move;
	}

	public function part2() {
		$starts =
			array_values( array_filter( array_keys( $this->nodes ),
				static fn( string $key ) => $key[2] === 'A' ) );

		$min = 1;
		foreach ( $starts as $start ) {
			$min = gmp_lcm( $min, $this->getNumberOfSteps( $start ) );
		}

		return $min;
	}
}