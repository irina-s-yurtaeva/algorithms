<?php

namespace Otus;

final class TestResult
{
	private float $microsec;
	private mixed $result;
	private bool $isFinished;

	public function __construct()
	{
		$this->microsec = microtime(true);
		$this->isFinished = false;
	}

	public function setResult(mixed $result): void
	{
		$this->result = $result;
		$this->microsec = microtime(true) - $this->microsec;
		$this->isFinished = true;
	}

	public function getExecutionTime(): ?float
	{
		return $this->microsec;
	}

	public function getResult(): mixed
	{
		return $this->result;
	}

	public function isFinished(): bool
	{
		return $this->isFinished;
	}
}