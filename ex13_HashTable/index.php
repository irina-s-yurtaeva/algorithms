<?php

namespace Otus\ex13_HashTable;

include_once __DIR__ . '/../Autoload.php';
$painter = new \Otus\PaintUtils();

$dataSets = [/*[
			'arm' => 34,
			'back' => 45,
			'calf' => 56,
			'd_liver' => 67,
			'ear' => 78,
			'forehead' => 89,
			'gallbladder' => 90,
			'head' => 1,
			'intestine  s' => 12,
			'joint' => 23
		], */
	[
		[1, 'ter Stegen'],
		[2, 'Semedo'],
		[3, 'Pique'],
		[4, 'Rakitic'],
		[5, 'Buskuets'],
		[6, 'Denis Suarez'],
		[7, 'Coutinho'],
		[8, 'Arthur'],
		[9, 'Luis Suarez'],
		[10, 'Messi'],
		[11, 'Dembele'],
		[12, 'Rafinha'],
		[13, 'Cillessen'],
		[14, 'Malcom'],
		[15, 'Lenglet'],
		[16, 'Samper'],
		[18, 'Alba'],
		[19, 'el Haddadi'],
		[20, 'Roberto'],
		[22, 'Vidal'],
		[23, 'Umtiti'],
		[24, 'Vermaelen'],
		[26, 'Alena'],
	]
];

$hashStorages = [new HashStorageChains(), new HashStorageOpenAddressLinear(), new HashStorageOpenAddressPirson()];
echo
	str_pad('Hash alg', 25, ' ', STR_PAD_LEFT)  . ' | ' .
	str_pad('Insert (time)', 15, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Insert (memo)', 15, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Remove (time)', 15, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Remove (memo)', 15, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Statistic', 35, ' ', STR_PAD_LEFT). ' | ' .
	PHP_EOL
;

try
{
	/* @var HashStorage $hashStorage */
	foreach ($hashStorages as $hashStorage)
	{
		$result = new \Otus\Result();
		foreach ($dataSets as $dataSet)
		{
			foreach ($dataSet as $data)
			{
				$hashStorage->add(...$data);
			}
		}
		$result->finalize();

		$memoryResults = [
			$result->getMemoryUsage(),
			$result->getTimeUsage(),
		];

		$result = new \Otus\Result();
		$dataSets = array_reverse($dataSets);
		foreach ($dataSets as $dataSet)
		{
			foreach ($dataSet as $data)
			{
				$hashStorage->delete($data[0]);
			}
		}
		$result->finalize();

		$memoryResults[] = $result->getMemoryUsage();
		$memoryResults[] = $result->getTimeUsage();

		echo str_pad($hashStorage->getName(), 25, ' ', STR_PAD_LEFT) . ' | ';
		array_walk($memoryResults, function($item) {echo str_pad($item, 15, ' ', STR_PAD_LEFT) . ' | '; });
		echo str_pad($hashStorage->getStatistic(), 35, ' ', STR_PAD_LEFT) . ' | ';

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