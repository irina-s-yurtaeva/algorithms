<?php
namespace Otus\AlgebraicAlgs;

use Otus\ex06_SimpleSort\ArrayFabric;
use Otus\ex06_SimpleSort\SortBubble;
use Otus\ex06_SimpleSort\SortBubbleEnhanced;
use Otus\ex06_SimpleSort\SortVisualizerHistogram;
use Otus\ex06_SimpleSort\SortVisualizerLoader;

include_once __DIR__ . '/../Autoload.php';

$array = ArrayFabric::createShuffle(10);
//$array = ArrayFabric::createSorted(10);

$histogram = new SortVisualizerHistogram();
$loader = new SortVisualizerLoader();
foreach ([
	\Otus\ex06_SimpleSort\SortBubble::class,
	\Otus\ex06_SimpleSort\SortBubbleEnhanced::class,
	\Otus\ex06_SimpleSort\SortSelection::class,
	\Otus\ex06_SimpleSort\SortInsertion::class,
	\Otus\ex06_SimpleSort\SortInsertionWithAShift::class,
	\Otus\ex06_SimpleSort\SortInsertionBinarySearch::class,
	\Otus\ex06_SimpleSort\SortShell::class,
] as $sortClass)
{
	$sortStrategy = (new $sortClass);
	$sortStrategy->setArray($array)
		->setVisualizer(
			count($array) < 50 && !($sortStrategy instanceof \Otus\ex06_SimpleSort\SortInsertionWithAShift) ? $histogram : $loader
		)->sort()
		->showResult()
	;
}

__halt_compiler();