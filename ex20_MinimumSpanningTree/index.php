<?php

namespace Otus\ex20_MinimumSpanningTree;

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
				['a', 'b', 7],
				['b', 'c', 8],
				['c', 'e', 5],
				['e', 'b', 7],
				['e', 'd', 15],
				['d', 'b', 9],
				['d', 'a', 5],
				['d', 'f', 6],
				['f', 'e', 8],
				['f', 'g', 11],
				['g', 'e', 9],
			],
			'answer' => [39]
		],
	] as $graphData)
	{
		$graph = ex18_Vertex\Graph::initFromEdgeData($graphData['data']);
		foreach ([PrimaAlg::class, KraskalaAlg::class, BoruvkiAlg::class] as $mstAlg)
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