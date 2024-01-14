<?php

namespace Otus\ex30_DynamicProgramming;

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
 |  __ \                                      (_)    __/ |                                                                       (_)                
 | |  | |  _   _   _ __     __ _   _ __ ___    _    |___/   _ __    _ __    ___     __ _   _ __    __ _   _ __ ___    _ __ ___    _   _ __     __ _ 
 | |  | | | | | | | '_ \   / _` | | '_ ` _ \  | |  / __|   | '_ \  | '__|  / _ \   / _` | | '__|  / _` | | '_ ` _ \  | '_ ` _ \  | | | '_ \   / _` |
 | |__| | | |_| | | | | | | (_| | | | | | | | | | | (__    | |_) | | |    | (_) | | (_| | | |    | (_| | | | | | | | | | | | | | | | | | | | | (_| |
 |_____/   \__, | |_| |_|  \__,_| |_| |_| |_| |_|  \___|   | .__/  |_|     \___/   \__, | |_|     \__,_| |_| |_| |_| |_| |_| |_| |_| |_| |_|  \__, |
            __/ |                                          | |                      __/ |                                                      __/ |
           |___/                                           |_|                     |___/                                                      |___/ 
ASCII;
echo $painter->resetColor();

try
{
	foreach ([
//		OneTwoPeas::class,
		FirTree::class,
	] as $taskClass)
	{
		$task = new $taskClass;
		echo $painter->colorFont([255, 255, 51]);
		echo PHP_EOL. PHP_EOL. 'Задача: ' . $task->getName(). PHP_EOL;
		echo $painter->resetColor();

		$task->apply();
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
