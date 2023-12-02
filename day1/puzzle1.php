<?php

$lines = explode("\n", file_get_contents('./input.txt'));

$answer = array_reduce(
	array_map(
		static fn ($num) => $num[0] . $num[strlen($num)-1],
		array_filter(
			array_map(
				static fn ($line) => preg_replace('/\D/', '', $line),
				$lines
			)
		)
	),
	static fn ($carry, $cur) => (int)$cur + $carry,
	0
);

echo $answer;