<?php

namespace Otus\ex35_ProbabilisticAlgorithms;

include_once __DIR__ . '/../Autoload.php';

$painter = new \Otus\PaintUtils();

echo $painter->colorFont([204, 0, 51]);
echo <<<ASCII
   ____    _                                    _                          _   _     _                                                              
  / __ \  | |                           /\     | |                        (_) | |   | |                                                             
 | |  | | | |_   _   _   ___           /  \    | |   __ _    ___    _ __   _  | |_  | |__    _ __ ___    ___                                        
 | |  | | | __| | | | | / __|         / /\ \   | |  / _` |  / _ \  | '__| | | | __| | '_ \  | '_ ` _ \  / __|                                       
 | |__| | | |_  | |_| | \__ \  _     / ____ \  | | | (_| | | (_) | | |    | | | |_  | | | | | | | | | | \__ \                                       
  \____/   \__|  \__,_| |___/ (_)   /_/    \_\ |_|  \__, |  \___/  |_|    |_|  \__| |_| |_| |_| |_| |_| |___/                     _
ASCII;
echo $painter->resetColor();

try
{
	$tasks = [
		BloomFilter::CODE => BloomFilter::class,
	];
	echo PHP_EOL . 'Введите один из кодов задачи для работы ' . PHP_EOL;
	foreach ($tasks as $code => $taskClass)
	{
		$task = new $taskClass;
		echo  'Задача: ' . $task->getName(). ' код ' . $code . PHP_EOL;

	}

//	while ($code = readline('Код задания: '))
	$code = BloomFilter::CODE;
	{
		if ($taskClass = $tasks[$code] ?? null)
		{
			$task = new $taskClass;
			echo $painter->colorFont([255, 255, 51]);
			echo PHP_EOL. PHP_EOL. 'Вероятностный алгоритм: ' . $task->getName(). PHP_EOL;
			echo $painter->resetColor();

			$task->apply();
		}
	}
}
catch (\Throwable $e)
{
	?><pre><b>$e: </b><?php print_r($e)?></pre><?php

	echo 'My error: ' . $e->getMessage();
}

//__halt_compiler();
