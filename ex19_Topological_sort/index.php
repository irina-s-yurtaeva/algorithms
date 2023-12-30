<?php

namespace Otus\ex19_Topological_sort;

use Otus\ex18_Vertex;

include_once __DIR__ . '/../Autoload.php';
try
{
	foreach ([
		[
			'data' => [
				['a', 'b', 1],
				['b', 'e', 1],
				['c', 'd', 1],
				['d', 'a', 1],
				['d', 'b', 1],
				['d', 'e', 1],
				['d', 'f', 1],
				['e', 'g', 1],
				['f', 'e', 1],
				['f', 'h', 1],
				['g', 'h', 1],
				['x', 'y', 1],
			],
			'answer' => [
				['c', 'x'],
				['d', 'y'],
				['a', 'f'],
				['b'],
				['e'],
				['g'],
				['h'],
			]
		],
	] as $graphData)
	{
		foreach ([
			DemucronAlg::class
		] as $alg)
		{
			$graph = ex18_Vertex\Graph::initFromEdgeData($graphData['data']);
			$sortAlg = (new $alg($graph));
			$result = $sortAlg->apply();

			$success = true;
			foreach ($result->getData() as $level => $vertecies)
			{
				$diff = array_diff($vertecies, $graphData['answer'][$level]);
				$success = empty($diff);
				if (!$success)
				{
					break;
				}
			}
			echo $sortAlg->getName() . ': ' . ($success ? 'succeed' : 'failed') . PHP_EOL;
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
	?><pre><b>$e: </b><?php print_r($e)?></pre><?php

	echo 'My error: ' . $e->getMessage();
}

//__halt_compiler();