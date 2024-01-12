<?php

namespace Otus\ex27_Archiver;

include_once __DIR__ . '/../Autoload.php';

$painter = new \Otus\PaintUtils();

echo 'Archiver' . PHP_EOL;
echo
	str_pad('Algorithm', 47, ' ', STR_PAD_LEFT)  . ' | ' .
	str_pad('Alg Time', 13, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Alg Memo', 13, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Efficiency', 20, ' ', STR_PAD_LEFT). ' | ' .
	PHP_EOL
;

try
{
	foreach ([
		'Strong string',
		'aaaaaaaaaaaaaaaaaaaaaaabbbbbbbbbbbbbbbbbbaaaaaaaaaaaaaaaabbbbbbbbbbbbbbb'
	] as $text)
	{
		echo 'Dataset: ' . $text . PHP_EOL;
		$rawData = (new DataText())->set($text);
		foreach ([
				[RLEZipAlg::class, RLEUnzipAlg::class],
				[RLE2ZipAlg::class, RLE2UnzipAlg::class],
//				[HuffmanZipAlg::class, HuffmanUnzipAlg::class],

			] as [$zipAlgClass, $unzipAlgClass])
		{
			/** @var \Otus\ex27_Archiver\ArchiverAlg $zip */
			$zip = (new $zipAlgClass)->setData($rawData);

			/** @var \Otus\Result $zipResult */
			$zipResult = $zip->apply();

			$columnZipped = $columnUnzipped = [
				$zip->getName(),
				'Error!!!',
				'Error!!!',
				'Error!!!',
				'Error!!!'
			];

			if ($zipResult->isSuccess())
			{
				[$zippedData] = $zipResult->getData();
				$zippedLen = strlen($zippedData->get());
				$rawLen = strlen($rawData->get());
				$efficiency = ($rawLen - $zippedLen) / $rawLen;

				$columnZipped = [
					$zip->getName(),
					$zipResult->getTimeUsage(),
					$zipResult->getMemoryUsage(),
//					$zip->getStats(),
					round($efficiency * 100) . '%'
				];


				/** @var \Otus\Result $unzipResult */
				$unzip = (new $unzipAlgClass)->setData($zippedData);
				$unzipResult = $unzip->apply();
				[$unzipped] = $unzipResult->getData();

				$columnUnzipped = [
					$unzip->getName(),
					$unzipResult->getTimeUsage(),
					$unzipResult->getMemoryUsage(),
//					$unzip->getStats(),
					$rawData->get() === $unzipped->get() ? 'Well done' : 'Error!!!!'
				];
			}

			foreach ([$columnZipped, $columnUnzipped] as $column)
			{
				echo
					str_pad($column[0], 47, ' ', STR_PAD_LEFT) . ' | ' .
					str_pad($column[1], 13, ' ', STR_PAD_LEFT). ' | ' .
					str_pad($column[2], 13, ' ', STR_PAD_LEFT). ' | ' .
					str_pad($column[3], 20, ' ', STR_PAD_LEFT). ' | ' .
//					str_pad($column[4], 13, ' ', STR_PAD_LEFT). ' | ' .
					PHP_EOL
				;
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
