<?php
namespace Otus\AlgebraicAlgs;

use Otus\ex06_SimpleSort\ArrayFabric;
use Otus\ex06_SimpleSort\SortBubble;
use Otus\ex06_SimpleSort\SortBubbleEnhanced;
use Otus\ex06_SimpleSort\SortVisualizer;

include_once __DIR__ . '/../Autoload.php';

$array = ArrayFabric::createShuffle(10);
//$array = ArrayFabric::createSorted(10);

exec('clear');
$decorator = new SortVisualizer();
foreach ([
//	\Otus\ex06_SimpleSort\SortBubble::class,
//	\Otus\ex06_SimpleSort\SortBubbleEnhanced::class
//	\Otus\ex06_SimpleSort\SortSelection::class
//	\Otus\ex06_SimpleSort\SortInsertion::class,
//	\Otus\ex06_SimpleSort\SortInsertionWithAShift::class,
	\Otus\ex06_SimpleSort\SortInsertionBinarySearch::class,
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