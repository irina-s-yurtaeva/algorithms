<?php

namespace Otus\ex21_ShortestPath;

use Otus\Alg;
use Otus\ex18_Vertex;
use Otus\Result;

include_once __DIR__ . '/../Autoload.php';

$painter = new \Otus\PaintUtils();
echo <<<ASCII
	Minimum Spanning Tree
ASCII;
echo PHP_EOL;


echo
	str_pad('Algorithm', 25, ' ', STR_PAD_LEFT)  . ' | ' .
	str_pad('Time', 13, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Memo', 13, ' ', STR_PAD_LEFT). ' | ' .
	PHP_EOL
;

try
{
	foreach ([
		[
			'data' => [
				['a', 'c', -2],
				['b', 'a', 4],
				['b', 'c', 3],
				['c', 'd', 2],
				['d', 'b', -1],
			],
			'answer' => [
				'a' => ['a' => 0, 'b' => -1, 'c' => -2, 'd' => 0],
				'b' => ['a' => 4, 'b' => 0, 'c' => 2, 'd' => 4],
				'c' => ['a' => 5, 'b' => 1, 'c' => 0, 'd' => 2],
				'd' => ['a' => 3, 'b' => -1, 'c' => 1, 'd' => 0],
			]
		],
	] as $graphData)
	{
		$graph = ex18_Vertex\Graph::initFromEdgeData($graphData['data']);
		foreach ([FloydWarshallAlg::class] as $mstAlg)
		{
			/** @var Alg $alg */
			$alg = (new $mstAlg($graph));
			/** @var Result $result */
			$result = $alg->apply();

			if ($graphData['answer'] === $result->getData())
			{
				echo
					str_pad($alg->getName(), 25, ' ', STR_PAD_LEFT)  . ' | ' .
					str_pad($result->getTimeUsage(), 13, ' ', STR_PAD_LEFT). ' | ' .
					str_pad($result->getMemoryUsage(), 13, ' ', STR_PAD_LEFT). ' | ' .
					PHP_EOL
				;
			}
			else
			{
				echo $painter->colorFont([200, 20, 70]);
				echo
					str_pad($alg->getName(), 25, ' ', STR_PAD_LEFT)  . ' | ' .
					str_pad('Error!', 13, ' ', STR_PAD_LEFT). ' | ' .
					str_pad('Error!', 13, ' ', STR_PAD_LEFT). ' | ' .
					PHP_EOL
				;
				echo $painter->resetColor();
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