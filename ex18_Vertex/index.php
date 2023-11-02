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
				['h', 'g'],
				['g', 'f'],
				['f', 'g'],
				['e', 'a'],
			],
			'Kosaraju' => [

			]
		],
	] as $graphData)
	{
		$result = new \Otus\TestResult();
		$graph = Graph::initFromEdgeData($graphData);
		print (new KosarajuAlg($graph))->getGraphs();

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