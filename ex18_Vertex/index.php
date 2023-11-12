<?php

namespace Otus\ex18_Vertex;

use Otus\ArrayFabric;

include_once __DIR__ . '/../Autoload.php';
$painter = new \Otus\PaintUtils();
if (isset($argv[1]))
{
	if ($argv[1] === '--help')
	{
		echo $painter->drawLowerPixel([200, 20, 70], '');
		echo <<<ASCII
--kosarajiu - show kosaraju search
--sort
ASCII;
		echo $painter::RESET_COLOR . PHP_EOL;
	}
	return;
}

try
{
	foreach ([
		[
			'data' => [
				['a', 'b'],
				['b', 'c'],
				['b', 'f'],
				['b', 'e'],
				['c', 'd'],
				['c', 'g'],
				['d', 'c'],
				['d', 'h'],
				['h', 'd'],
				['h', 'g'],
				['g', 'f'],
				['f', 'g'],
				['e', 'a'],
				['e', 'f'],
			],
			'Kosaraju' => [
				['g', 'f'],
				['h', 'd', 'c'],
				['a', 'b', 'e'],
			]
		],
	] as $graphData)
	{
		$graph = Graph::initFromEdgeData($graphData['data']);
		$result = (new KosarajuAlg($graph))->apply();

		foreach ($result->getData() as $subGraph)
		{
			echo 'Strongly connected Subgraph: ' . PHP_EOL;
			foreach ($subGraph as $v)
			{
				echo $v . PHP_EOL;
			}
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