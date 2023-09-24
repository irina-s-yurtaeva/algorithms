<?php

namespace Otus\ex06_SimpleSort;

class SortVisualizerTable extends SortVisualizerAbstract
{
	private static $firstCall = true;

	public function onSorted(int $length, int $assigment,int $comparisson): void
	{
		$timeResult = (microtime(true) - $this->timestamp) * 1000000;
		$className = get_class($this->strategy);
		$className = substr($className, strrpos($className, '\\') + 1);
		if (self::$firstCall)
		{
			self::$firstCall = false;
			echo str_pad('Classname', 32)
				. ' | ' . str_pad('array size', 10)
				. ' | ' . str_pad('assigments', 10)
				. ' | ' . str_pad('comparissons ', 13)
				. ' | ' . str_pad('time', 10) . PHP_EOL
			;
		}
		echo str_pad($className, 32)
			. ' | ' . str_pad($length, 10)
			. ' | ' . str_pad($assigment, 10)
			. ' | ' . str_pad($comparisson, 13)
			. ' | ' . str_pad(round($timeResult), 10) . PHP_EOL
		;
	}

	public function onCompare(int $indexFrom, int $indexTo): void
	{

	}

	public function onCompared(int $indexFrom, int $indexTo, bool $result): void
	{

	}

	public function onSwapped(int $indexFrom, int $indexTo): void
	{

	}

	public function onSwap(int $indexFrom, int $indexTo): void
	{

	}
}
