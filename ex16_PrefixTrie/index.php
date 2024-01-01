<?php

namespace Otus\ex16_PrefixTrie;

include_once __DIR__ . '/../Autoload.php';
use Otus\ex13_HashTable;

$painter = new \Otus\PaintUtils();

function readTheFile($path)
{
	$handle = fopen($path, "r");

	while(!feof($handle))
	{
		yield trim(fgets($handle));
	}

	fclose($handle);
}

echo
	str_pad('Hash alg', 25, ' ', STR_PAD_LEFT)  . ' | ' .
	str_pad('Insert (time)', 15, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Insert (memo)', 15, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Get (time)', 15, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Get (memo)', 15, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Failed answers', 15, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Statistic', 35, ' ', STR_PAD_LEFT). ' | ' .
	PHP_EOL
;

try
{
	$hashStorages = [
		(new ex13_HashTable\HashStorageChains())->setSize(1000),
		new ex13_HashTable\HashStorageOpenAddressLinear(),
		new PrefixTrie(),
	];
	$iterator = readTheFile(__DIR__ . '/english-19350-4a22b7.txt');
	$checkWords = [];
	foreach ($iterator as $dataString)
	{
		if (rand(0, 5) === 2)
		{
			$data = explode("\t", $dataString);
			$checkWords[$data[0]] = $data[2];
		}
	}

	/* @var ex13_HashTable\HashStorageChains $hashStorage */
	foreach ($hashStorages as $hashStorage)
	{
		$insertResult = new \Otus\Result();
		$iterator = readTheFile(__DIR__ . '/english-19350-4a22b7.txt');
		foreach ($iterator as $dataString)
		{
			$data = explode("\t", $dataString);
			$hashStorage->add($data[0], $data[2]);
		}
		$insertResult->finalize();

		$memoryResults = [
			$insertResult->getTimeUsage(),
			$insertResult->getMemoryUsage(),
		];
		$getResult = new \Otus\Result();
		$failedAnswers = 0;
/*		foreach ($checkWords as $askKey => $expectedAnswer)
		{
			$value = $hashStorage->get($askKey);
			if (!in_array($expectedAnswer, $value))
			{
				echo '$value: ' . $value . ' $expectedAnswer: ' . $expectedAnswer . PHP_EOL;
				$failedAnswers++;
			}
		}*/
		$getResult->finalize();
		$memoryResults[] = $getResult->getTimeUsage();
		$memoryResults[] = $getResult->getMemoryUsage();

		$memoryResults[] = $failedAnswers . ' / ' . count($checkWords);

		echo str_pad($hashStorage->getName(), 25, ' ', STR_PAD_LEFT) . ' | ';
		array_walk($memoryResults, function($item) {echo str_pad($item, 15, ' ', STR_PAD_LEFT) . ' | '; });
		echo str_pad($hashStorage->getStatistic(), 35, ' ', STR_PAD_LEFT) . ' | ';
		unset($hashStorage, $memoryResults, $getResult, $insertResult, $iterator);
		echo PHP_EOL;
	}
}
catch (\Otus\TimeoutException $e)
{
	?><pre><b>$e: </b><?php print_r($e)?></pre><?php
}
catch (\Throwable $e)
{
	?><pre><b>$e: </b><?php print_r($e)?></pre><?php

	echo 'My error: ' . $e->getMessage();
}

//__halt_compiler();