<?php

namespace Otus\ex06_SimpleSort;

abstract class SortAlgs implements ISortArray
{
	protected array $array = [];
	protected int $length = 0;
	protected int $comparison = 0;
	protected int $assignment = 0;

	public function set(array $array): static
	{
		$this->array = $array;
		$this->length = count($array);
		return $this;
	}

	public function get(): array
	{
		return $this->array;
	}

	abstract public function sort(): static;

	abstract public function compare($one, $two): bool;


	protected function needToSwap($indexFrom, $indexTo): bool
	{
		$this->comparison++;
		return $this->compare($this->array[$indexFrom], $this->array[$indexTo]);
	}

	public function swap(int $indexFrom, int $indexTo): void
	{
		$this->assignment += 3;
		$buffer = $this->array[$indexFrom];
		$this->array[$indexFrom] = $this->array[$indexTo];
		$this->array[$indexTo] = $buffer;
	}

	public function __toString(): string
	{
		return "Elements: $this->length, Assignments: $this->assignment, Comparison: $this->comparison";
	}

	public function showInfo(): static
	{
		echo $this . PHP_EOL;
		return $this;
	}
}
