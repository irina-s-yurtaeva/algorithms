<?php
define('OTUS_01_MAGIC_SQUARE_SIZE', 25);
function makeASquare($stategy)
{
	for ($y = 1; $y <= OTUS_01_MAGIC_SQUARE_SIZE; $y++)
	{
		for ($x = 1; $x <= OTUS_01_MAGIC_SQUARE_SIZE; $x++)
		{
			echo call_user_func($stategy, $x, $y);
		}
		echo "\r\n";
	}
}
foreach([
	'1. Simple' => function(int $x, int $y) { return $x > $y ? '#' : '.';},
	'2. Line' => function(int $x, int $y) { return $x === $y ? '#' : '.';},
	'3. Line2' => function(int $x, int $y) { return $x === (OTUS_01_MAGIC_SQUARE_SIZE - $y) ? '#' : '.';},
	'4. Pentagon' => function(int $x, int $y) { return $x <= (OTUS_01_MAGIC_SQUARE_SIZE - $y + 5) ? '#' : '.';},
	'5. Division and round' => function(int $x, int $y) { return round($x / 2) == $y ? '#' : '.';},
	'6. Dotted square' => function(int $x, int $y) { return $x > 10 && $y > 10 ? '#' : '.';},
	'7. Sharped square' => function(int $x, int $y) { return (OTUS_01_MAGIC_SQUARE_SIZE - $x) < 10 && (OTUS_01_MAGIC_SQUARE_SIZE - $y) < 10 ? '#' : '.';},
	'8. Bordering' => function(int $x, int $y) { return $x === 1 || $y === 1 ? '#' : '.';},
	'9. Row' => function(int $x, int $y) { return $x <= ($y - 10) || $x >= ($y + 10) ? '#' : '.';},
	'10. Window' => function(int $x, int $y) {
		return $x === 2 || $x === OTUS_01_MAGIC_SQUARE_SIZE - 1 || $y === 2 || $y === OTUS_01_MAGIC_SQUARE_SIZE - 1
			? '#' : '.';
	},
	'11. Circle' => function(int $x, int $y) { return sqrt(pow(($x - 1), 2) + pow(($y - 1), 2)) <= 20 ? '#' : '.';},
//	'12. ' => function(int $x, int $y) { return $x <= $y ? '.' : (round($x / 2) <= $y ? '#' : '.');},
//	'13. ' => function(int $x, int $y) { return $x <= $y ? '.' : (round($x / 2) <= $y ? '#' : '.');},
//	'14. ' => function(int $x, int $y) { return $x <= $y ? '.' : (round($x / 2) <= $y ? '#' : '.');},
//	'15. ' => function(int $x, int $y) { return $x <= $y ? '.' : (round($x / 2) <= $y ? '#' : '.');},
//	'16. ' => function(int $x, int $y) { return $x <= $y ? '.' : (round($x / 2) <= $y ? '#' : '.');},

] as $key => $strategy)
{
	echo $key."\n";
	makeASquare($strategy);
	echo "/".$key."\n\n";

}
