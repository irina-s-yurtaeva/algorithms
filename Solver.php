<?php

namespace Otus;

abstract class Solver
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

	abstract protected function prepareResult(mixed $inputData): mixed;

	public function solve(mixed $inputData): \Otus\TestResult
	{
		$result = new \Otus\TestResult();

		$this->startTimer();
		$result->setResult(
			$this->prepareResult($inputData)
		);

		return $result;
	}
}

