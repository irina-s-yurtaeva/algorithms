<?php
namespace Otus\ex07_ExternalSort;

use Otus\ArrayFabric;

include_once __DIR__ . '/../Autoload.php';
$painter = new \Otus\PaintUtils();
if (isset($argv[1]))
{
	if ($argv[1] === '--help')
	{
		echo $painter->drawLowerPixel([200, 20, 70], '');
		echo <<<ASCII
--generate <StringsCount> <NumberRange> To generate file
--sort
ASCII;
		echo $painter::RESET_COLOR . PHP_EOL;
	}
	return;
}

echo
	str_pad('Algorithm', 20, ' ', STR_PAD_LEFT)  . ' | ' .
	str_pad('Build (time)', 13, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Build (memo)', 13, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Search (res)', 13, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Search (time)', 13, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Search (memo)', 13, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Remove (time)', 13, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Remove (memo)', 13, ' ', STR_PAD_LEFT). ' | ' .

	PHP_EOL
;

try
{
	foreach ([
//		[3,1, 7, 4, 0, 2,5],
		//	ArrayFabric::createShuffle(5),
		//	ArrayFabric::createShuffle(10),
			ArrayFabric::createShuffle(20),
//			ArrayFabric::createShuffle(100),
//			ArrayFabric::createShuffle(1000),
//			ArrayFabric::createShuffle(10000),
//			ArrayFabric::createShuffle(100000),
//			ArrayFabric::createShuffle(1000000),
//			ArrayFabric::createShuffle(10000000),
	] as $array)
	{
		$count = count($array);
		$elements = $count > 10 ? range(0, $count - 1, 10) : [];
		$elementsCount = count($elements);
		echo "Tree nodes: $count and testing elements: $elementsCount" . PHP_EOL;

		foreach ([
			\Otus\ex10_AVL\TreeBinary::class,
			//		\Otus\ex10_AVL\TreeAVL::class,
			//		\Otus\ex10_AVL\TreeTreap::class,
		] as $treelass)
		{
			/* @var \Otus\ex10_AVL\Tree $tree */
			$tree = new $treelass;

			$makeATreeResult = $tree->makeBinaryTreeFromArray($array);
			$searchResult = $tree->searchElements($elements);
			$removeResult = $tree->removeElements($elements);

			echo
				str_pad($treelass::CODE, 20, ' ', STR_PAD_LEFT) . ' | ' .
				str_pad($makeATreeResult->getTimeUsage(), 13, ' ', STR_PAD_LEFT). ' | ' .
				str_pad($makeATreeResult->getMemoryUsage(), 13, ' ', STR_PAD_LEFT). ' | ' .
				str_pad($searchResult->getAffectedElementsCount() . '/' . $searchResult->getElementsCount(), 13, ' ', STR_PAD_LEFT). ' | ' .
				str_pad($searchResult->getTimeUsage(), 13, ' ', STR_PAD_LEFT). ' | ' .
				str_pad($searchResult->getMemoryUsage(), 13, ' ', STR_PAD_LEFT). ' | ' .
				str_pad($removeResult->getTimeUsage(), 13, ' ', STR_PAD_LEFT). ' | ' .
				str_pad($removeResult->getMemoryUsage(), 13, ' ', STR_PAD_LEFT). ' | ' .
				PHP_EOL
			;
		}

		if ($makeATreeResult->isFinalized())
		{
			$result = new \Otus\Result();
			$dfs = new \Otus\ex10_AVL\VisitorDFSort();
			$sorted = $dfs->apply($makeATreeResult->getData()['root']);
			$result->finalize();
			echo "Sorting in the last tree: " . $result->getTimeUsage() . ': '
				. implode(' ', array_slice($sorted, 0, 10))
				. '...'
				. implode(' ', array_slice($sorted, -10, 10))
				. PHP_EOL;

			$result = new \Otus\Result();
			$dfs = new \Otus\ex10_AVL\VisitorDFSearcher();
			$foundelementsCount = 0;
			foreach ($elements as $element)
			{
				$foundNode = $dfs->apply($makeATreeResult->getData()['root'], $element);
				if ($foundNode !== null)
				{
					$foundelementsCount++;
				}
			}
			$result->finalize();
			echo "Searching in the last tree: " . $result->getTimeUsage() . '. Need to search: '
				. $elementsCount
				. ' and found: '
				. $foundelementsCount
				. PHP_EOL;
		}

	}
}
catch (\Otus\TimeoutException $e)
{
	?><pre><b>$e: </b><?php print_r($e)?></pre><?php
	;
}
catch (\Throwable $e)
{
	echo 'My error: ' . $e->getMessage();
}

//__halt_compiler();