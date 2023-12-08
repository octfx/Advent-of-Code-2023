<?php

declare( strict_types=1 );

namespace Octfx\Aoc23D8;

use RuntimeException;

class FileParser {
	private string $filePath;

	/**
	 * @param string $path Path to the input.txt
	 */
	public function __construct( string $path ) {
		$this->filePath = $path;
	}

	public function getMap(): Map {
		if ( !file_exists( $this->filePath ) ) {
			throw new RuntimeException( sprintf( 'Input file "%s" does not exist.',
				$this->filePath ) );
		}

		$content = file_get_contents( $this->filePath );

		if ( !is_string( $content ) || $content === '' ) {
			throw new RuntimeException( sprintf( 'Could not read content of file "%s".',
				$this->filePath ) );
		}

		$lines = explode( "\n", trim( $content ) );
		$directions = array_shift( $lines );


		$nodes = [];

		foreach ( array_filter( $lines ) as $line ) {
			$parts = array_map( static fn( string $part ) => trim( $part ), explode( '=', $line ) );
			$moves =
				array_map( static fn( string $part ) => trim( $part, " \n\r\t\v\0()" ),
					explode( ',', $parts[1] ) );

			$nodes[$parts[0]] = $moves;
		}

		return new Map( $directions, $nodes );
	}
}