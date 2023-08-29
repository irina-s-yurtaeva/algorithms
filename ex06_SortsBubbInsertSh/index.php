<?php
namespace Otus\AlgebraicAlgs;

include_once __DIR__ . '/../Autoload.php';

use Otus\Tester;
use Otus\TestResult;

$timelimitSeconds = 1;
const HISTOGRAM_SIZE = 10;
function printArray(array $output, $delta) {
	$height = HISTOGRAM_SIZE;
	$offset = 4;
	$x = 0;
	foreach ($output as $value)
	{
		$yToPrint = $value / $delta * $height;

		for ($y = 0; $y <= $height; $y++)
		{
			echo chr(27) . "[" . $y. ";". ($offset + $x) . "H";
			if ($y < $yToPrint)
			{
				echo chr(27) . "[45 m";
				echo " ";
			}
			else
			{
				echo chr(27) . "[49 m";
				echo " ";
			}
		}
		$x++;
	}

//	echo implode(PHP_EOL, $output);
//	echo chr(27) . "[0G";
//	echo chr(27) . "[" . $oldLines . "A";

//	$numNewLines = $oldLines;

}
system('clear');
system('clear');
$out = fopen('php://output', 'w'); //output handler
$example = array_fill(0, 2, 1);
/*while (true) {
	$output = [];
	$output[] = 'First Line';
	$output[] = 'Time: ' . date('r');
	$output[] = 'Random number: ' . rand(100, 999);
	$output[] = 'Random letter: ' . chr(rand(65, 89));
	$output[] = 'Last Line';
	replaceCommandOutput($output);
	usleep(100000);
}*/
//region draw a field. Start
for ($y = 0; $y <= HISTOGRAM_SIZE; $y++)
{
	echo str_pad($y, 2, ' ', STR_PAD_LEFT).PHP_EOL;
}
//endregion

printArray($example, 100);

//region draw a field. End
echo chr(27) . "[" . (HISTOGRAM_SIZE + 2). ";". 0 . "H";
//endregion

fclose($out); //closing handler
