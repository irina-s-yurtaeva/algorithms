<?php
namespace Otus\ex07_ExternalSort;

include_once __DIR__ . '/../Autoload.php';
$painter = new \Otus\PaintUtils();
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
			\Otus\ex07_ExternalSort\TestFile::generate($argv[2], $argv[3], __DIR__ . '/testFiles/source_%s.txt');
		}
	}

	return;
}

echo
	str_pad('Algorithm', 20, ' ', STR_PAD_LEFT)  . ' | ' .
	str_pad('Counts', 7, ' ', STR_PAD_LEFT). ' | ' .
	str_pad('Time', 10, ' ', STR_PAD_LEFT) .
	PHP_EOL
;

foreach (range(2, 6) as $numberOrder)
{
	$file = \Otus\ex07_ExternalSort\TestFile::getInstanceForTheTest(
		__DIR__ . '/testFiles/source_pow_' . $numberOrder . '.txt', 10 ** $numberOrder, 5 ** $numberOrder
	);
	foreach ([
		\Otus\ex07_ExternalSort\SortExternal2::class
	] as $sortClass)
	{
		$className = trim(str_replace(__NAMESPACE__, '', $sortClass), '/\\');
		/* @var TestFile $file */
		/* @var SortExternal2 $sortAlg */
		$sortAlg = new $sortClass;
		$sortAlg->sortFile($file, __DIR__ . '/testFiles/' . $className . '_' . $numberOrder . '.txt');

		echo
			str_pad($className, 20, ' ', STR_PAD_LEFT) . ' | ' .
			str_pad(10 ** $numberOrder, 7, ' ', STR_PAD_LEFT). ' | ' .
			str_pad($sortAlg->getAnswer(), 10, ' ', STR_PAD_LEFT).
			PHP_EOL
		;
	}
}

//__halt_compiler();