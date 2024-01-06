<?php

namespace Otus;

abstract class Alg
{
	protected $iterations = 0;
	abstract public function getName(): string;

	protected function iterate(int $inc = 1): static
	{
		$this->iterations += $inc;

		return $this;
	}
	public function apply(): Result
	{
		$result = new Result();
		$this->iterations = 0;

		return $result;
	}

	public function resetStats(): static
	{
		$this->iterations = 0;

		return $this;
	}
	public function getStats(): string
	{
		return 'iterations: ' . $this->iterations;
	}
}
