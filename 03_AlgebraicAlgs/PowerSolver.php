<?php

namespace Otus\AlgebraicAlgs;

abstract class PowerSolver
{
	protected int $timeLimit = 10;
	protected int $timer;

	public function __construct(int $timeLimit = 10)
	{
		$this->timeLimit = $timeLimit;
	}

	public function getTitle(): string
	{
		$res = explode('\\', static::class);
		return end($res);
	}

	public function startTimer(): static
	{
		$this->timer = microtime(true);
		return $this;
	}
	/**
	 * @throws \Exception
	 */
	public function checkTimer(): bool
	{
		if (microtime(true) - $this->timer > $this->timeLimit)
		{
			throw new \Exception('Time limit is exceeded', 504);
		}
		return true;
	}

	abstract protected function makeCalculations(float $base, int $power): float;

	public function calculate(float $base, int $power): \Otus\TestResult
	{
		$result = new \Otus\TestResult();
		if ($power < 0)
		{
			$result->setResult(false);
		}
		else if ($power === 0)
		{
			$result->setResult(1);
		}
		else
		{
			$this->startTimer();
			$result->setResult($this->makeCalculations($base, $power));
		}

		return $result;
	}
}

