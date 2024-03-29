<?php

namespace Otus\ex09_BillionNumbersSort;

use Cassandra\Time;
use Otus\ex07_ExternalSort\TestFile;
use Otus;
use Otus\Result;
use Otus\Timer;

abstract class SortAlg extends Otus\Alg
{
	protected Timer $timer;
	protected int $statsFinalElementsCount = 0;

	public function __construct(protected TestFile $file)
	{
		$this->timer = new Timer(60 * 4);
	}

	public function apply(): Result
	{
		try
		{
			$result = parent::apply();
			$this->sort();
			$result->finalize();
		}
		catch (\Otus\TimeoutException $e)
		{
			$result->addError(new \Error($e->getMessage(), $e->getCode(), $e));
		}
		catch (\Throwable $e)
		{
			$result->addError(new \Error($e->getMessage(), $e->getCode(), $e));
		}

		return $result;
	}

	abstract public function sort(): void;

	public function getStats(): string
	{
		$res = parent::getStats()
			. ' FinalElementsCount: ' . $this->statsFinalElementsCount
		;

		return $res;
	}
}
