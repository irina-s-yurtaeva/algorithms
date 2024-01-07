<?php
namespace Otus\ex09_BillionNumbersSort;

include_once __DIR__ . '/../Autoload.php';

use \Otus\ex07_ExternalSort\TestFile;

$painter = new \Otus\PaintUtils();
try
{
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
		elseif ($argv[1] === '--generate')
		{
			if (!isset($argv[2]) || !isset($argv[3]))
			{
				echo $painter->drawLowerPixel([200, 20, 70], '');
				echo <<<ASCII
	--generate <StringsCount> <NumberRange> To generate file
	
	You have entered wrong parameters.
	ASCII;
				echo $painter::RESET_COLOR . PHP_EOL;
			}
			else
			{
				TestFile::generate(
					sprintf(__DIR__ . '/testFiles/source_%d_%d.txt', $argv[2], $argv[3]), $argv[2], $argv[3]
				);
			}
		}

		return;
	}

echo
	str_pad('Algorithm', 30, ' ', STR_PAD_LEFT)  . ' | ' .
	str_pad('Time', 15, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Memory', 15, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Stats', 10, ' ', STR_PAD_LEFT) .
	PHP_EOL
;

	$files = new \FilesystemIterator(__DIR__ . '/testFiles/', \FilesystemIterator::SKIP_DOTS);
	foreach ($files as $fileHandler)
	{
		$file = \Otus\ex07_ExternalSort\TestFile::getInstanceForTheTest(
			$fileHandler->getRealPath()
		);
		echo $fileHandler->getBasename() . PHP_EOL;
		foreach ([
			BucketSortAlg::class,
			RadixSortAlg::class,
			CountingSortAlg::class,
		] as $sortClass)
		{
			/** @var SortAlg $sortAlg */
			$sortAlg = new $sortClass($file);

			$result = $sortAlg->apply();

			echo
				str_pad($sortAlg->getName(), 30, ' ', STR_PAD_LEFT) . ' | ' .
				str_pad($result->isFinalized() ? $result->getTimeUsage() : 'Not finished', 15, ' ', STR_PAD_LEFT). ' | ' .
				str_pad($result->isFinalized() ? $result->getMemoryUsage() : 'Not finished', 15, ' ', STR_PAD_LEFT). ' | ' .
				str_pad($result->isSuccess() ? $sortAlg->getStats() : $result->getErrorMessage(), 10, ' ', STR_PAD_LEFT).
				PHP_EOL
			;
		}
	}
}
catch (\Throwable $e)
{
	?><pre><b>$e: </b><?php print_r($e)?></pre><?php

	echo 'My error: ' . $e->getMessage();
}
