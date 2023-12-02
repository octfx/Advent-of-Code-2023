<?php

$lines = explode("\n", file_get_contents('./input.txt'));

$numbers = [
	'one',
	'two',
	'three',
	'four',
	'five',
	'six',
	'seven',
	'eight',
	'nine',
	'\d'
];

$flipped = array_flip($numbers);

$pattern = sprintf('/(%s)/', implode('|', $numbers));

$linesToNumbers =

array_map(
	// Return the first and last number from each line
	static fn ($numbers) => $numbers[0] . $numbers[count($numbers)-1],
	array_map(
		// Convert spelled out numbers to ints
		static fn ($numbers) => array_map(
			static fn ($number) => isset($flipped[$number]) ? ($flipped[$number] + 1) : $number,
			$numbers
		),
		// Remove possible empty lines
		array_filter(
			// Find the numbers in each line and output an array
			// This is indeed just brute force as I'm too lazy
			array_map(
				static function ($line) use ($pattern) {
					$len = strlen($line);

					$allMatches = [];

					for ( $i = 0; $i < $len; $i ++ ) {
						$matched = preg_match($pattern, $line, $matches, 0, $i);

						if ($matched === 1) {
							$allMatches[] = $matches[0][0];
						}
					}

					if (!empty($allMatches)) {
						return $allMatches;
					}

					return [];
				},
				$lines
			),
		),
	)
);

$answer = array_reduce(
	$linesToNumbers,
	static fn ($carry, $cur) => (int)$cur + $carry,
	0
);

echo $answer;