<?php
namespace Otus\AlgebraicAlgs;

use Otus\ArrayFabric;
use Otus\ex06_SimpleSort\SortBubbleEnhanced;
use Otus\ex06_SimpleSort\SortVisualizerHistogram;
use Otus\ex06_SimpleSort\SortVisualizerLoader;
use Otus\ex06_SimpleSort\SortVisualizerTable;

include_once __DIR__ . '/../Autoload.php';

$isBrief = isset($argv[1]) && $argv[1] === '--brief';
if ($isBrief)
{
	$histogram = $loader = new SortVisualizerTable();
}
else
{
	$histogram = new SortVisualizerHistogram();
	$loader = new SortVisualizerLoader();
}
//$array = ArrayFabric::createSorted(10);

foreach ([
//	[3,1,4,0,2],
//	ArrayFabric::createShuffle(5),
//	ArrayFabric::createShuffle(10),
//	ArrayFabric::createShuffle(20),
	ArrayFabric::createShuffle(100),
	ArrayFabric::createShuffle(1000),
	ArrayFabric::createShuffle(10000),
	ArrayFabric::createShuffle(100000),
	ArrayFabric::createShuffle(1000000),
	ArrayFabric::createShuffle(10000000),
] as $array)
{
	foreach ([
//		\Otus\ex06_SimpleSort\SortBubble::class,
//		\Otus\ex06_SimpleSort\SortBubbleEnhanced::class,
//		\Otus\ex06_SimpleSort\SortSelection::class,
//		\Otus\ex06_SimpleSort\SortInsertion::class,
//		\Otus\ex06_SimpleSort\SortInsertionWithAShift::class,
//		\Otus\ex06_SimpleSort\SortInsertionBinarySearch::class,
//		\Otus\ex06_SimpleSort\SortShell::class,
//		\Otus\ex06_SimpleSort\SortHeap::class,
		\Otus\ex06_SimpleSort\SortQuick::class,
		\Otus\ex06_SimpleSort\SortMerge::class,
	] as $sortClass)
	{
		$sortStrategy = (new $sortClass);
		$sortStrategy->setArray($array)
			->setVisualizer(
				$histogram->checkStrategy($sortStrategy) ? $histogram : $loader
			)->sort()
		;
	}
}

//__halt_compiler();
