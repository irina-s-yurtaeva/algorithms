<?php
namespace Otus\AlgebraicAlgs;

use Otus\ex06_SimpleSort\ArrayFabric;
use Otus\ex06_SimpleSort\SortBubble;
use Otus\ex06_SimpleSort\SortBubbleEnhanced;
use Otus\ex06_SimpleSort\SortVisualizer;

include_once __DIR__ . '/../Autoload.php';

$array = ArrayFabric::createShuffle(10);
//$array = ArrayFabric::createSorted(10);

$decorator = new SortVisualizer();

foreach ([
//	\Otus\ex06_SimpleSort\SortBubble::class,
//	\Otus\ex06_SimpleSort\SortBubbleEnhanced::class
//	\Otus\ex06_SimpleSort\SortSelection::class
//	\Otus\ex06_SimpleSort\SortInsertion::class,
//	\Otus\ex06_SimpleSort\SortInsertionWithAShift::class,
//	\Otus\ex06_SimpleSort\SortInsertionBinarySearch::class,
	\Otus\ex06_SimpleSort\SortShell::class,
] as $sortClass)
{
	$sortStrategy = (new $sortClass)->set($array);
	if (count($array) < 200)
	{
		$sortStrategy = $decorator->setStrategy($sortStrategy);
	}

	$sortStrategy->sort()->showInfo();
}

__halt_compiler();

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
	echo str_pad($y, strlen(HISTOGRAM_SIZE), ' ', STR_PAD_LEFT).PHP_EOL;
}
//endregion

printArray($example, 100);

//region draw a field. End
echo "\e[45m00;\e0" . PHP_EOL;
//endregion

fclose($out); //closing handler
