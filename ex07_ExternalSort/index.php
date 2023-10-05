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

foreach ([
	\Otus\ex07_ExternalSort\TestFile::getInstanceForTheTest(__DIR__ . '/testFiles/source_20.txt', 20, 5),
] as $file)
{
	foreach ([
		\Otus\ex07_ExternalSort\SortExternal2::class
	] as $sortClass)
	{
		$className = trim(str_replace(__NAMESPACE__, '', $sortClass), '/\\');
		/* @var TestFile $file */
		/* @var SortExternal2 $sortAlg */
		$sortAlg = new $sortClass;
		$sortAlg->sortFile($file, __DIR__ . '/testFiles/' . $className . '_' . $file->getLength() . '.txt');
	}
}

//__halt_compiler();