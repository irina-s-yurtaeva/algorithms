<?php

namespace Otus\ex24_StringSearch;

use Otus\Alg;
use Otus\Result;

abstract class AbstractScanAlg extends Alg
{
	protected $iterations = 0;
	public function __construct(protected string $text, protected string $pattern)
	{

	}

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

	public function getStats(): string
	{
		return 'iterations: ' . $this->iterations;
	}
}
