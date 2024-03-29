<?php

namespace Otus\ex24_StringSearch;

include_once __DIR__ . '/../Autoload.php';

$painter = new \Otus\PaintUtils();

echo 'String search' . PHP_EOL;
echo
	str_pad('Algorithm', 47, ' ', STR_PAD_LEFT)  . ' | ' .
	str_pad('Time', 13, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Memo', 13, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Stat', 13, ' ', STR_PAD_LEFT). ' | ' .
	PHP_EOL
;

try
{
	foreach ([
		[
			'text' => 'Strong string',
			'pattern' => 'rong',
			'answer' => [2]
		],
		[
			'text' => 'Strong string',
			'pattern' => 'ring',
			'answer' => [9]
		],
		[
			'text' => 'Strong string',
			'pattern' => 'sring',
			'answer' => [null]
		],
		[
			'text' => 'aabcaabaabaaabaadabaabaabaaabdaaabaabaabaaabtaabaabaabaaaba',
			'pattern' => 'aabaabaabaaaba',
			'answer' => [45]
		],
		[
			'text' => 'aabcaabaabaaabaadabaabaabaaabdaaabaabaabaaabtaabaabaabaaabraabcaabaabaaabaadabaabaabaaabdaaabaabaabaaabtaabaabaabaaabtaabcaabaabaaabaadabaabaabaaabdaaabaabaabaaabtaabaabaabaaayaabcaabaabaaabaadabaabaabaaabdaaabaabaabaaabtaabaabaabaaaba',
			'pattern' => 'aabaabaabaaaba',
			'answer' => [221]
		],
	] as $scanData)
	{
		echo 'Text: "' . $scanData['text'] . '" pattern: "' . $scanData['pattern'] . '"' . PHP_EOL;

		foreach ([
			FullScanAlg::class,
			BoyerMooreLightAlg::class,
			BoyerMooreAlg::class,

			FiniteAutomataAlg::class,
			FiniteAutomataWithPrefixAlg::class,
			FiniteAutomataWithFastPrefixAlg::class,
			KMPAlg::class,
			] as $alg)
		{
			/** @var \Otus\Alg $alg */
			$alg = (new $alg($scanData['text'], $scanData['pattern']));
			/** @var \Otus\Result $result */
			$result = $alg->apply();
//			echo '$result: ', implode(', ', $result->getData())."\n";

			$column = [
				'Error!!!',
				'Error!!!',
				'Error!!!',
			];

			if ($scanData['answer'] === $result->getData())
			{
				$column = [
					$result->getTimeUsage(),
					$result->getMemoryUsage(),
					$alg->getStats(),
				];
			}
			echo
				str_pad($alg->getName(), 47, ' ', STR_PAD_LEFT) . ' | ' .
				str_pad($column[0], 13, ' ', STR_PAD_LEFT). ' | ' .
				str_pad($column[1], 13, ' ', STR_PAD_LEFT). ' | ' .
				str_pad($column[2], 13, ' ', STR_PAD_LEFT). ' | ' .
				PHP_EOL
			;

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
