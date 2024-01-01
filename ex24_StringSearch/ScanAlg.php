<?php

namespace Otus\ex24_StringSearch;

use Otus\Alg;
use Otus\Result;

abstract class ScanAlg extends Alg
{
	protected $iterations = 0;
	public function __construct(protected string $text, protected string $pattern)
	{

	}

	protected function iterate(): static
	{
		$this->iterations++;

		return $this;
	}

	public function apply(): Result
	{
		$result = new Result();
		$this->iterations = 0;

		return $result;
	}

	public function getStats(): string
	{
		return 'iterations: ' . $this->iterations;
	}
}