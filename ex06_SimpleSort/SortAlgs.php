<?php

namespace Otus\ex06_SimpleSort;

abstract class SortAlgs
{
	protected array $array = [];
	protected int $length = 0;
	protected int $comparison = 0;
	protected int $assignment = 0;
	protected SortVisualizerAbstract $visualizer;

	public function setArray(array $array): static
	{
		$this->array = $array;
		$this->length = count($array);

		return $this;
	}

	public function setVisualizer(SortVisualizerAbstract $visualizer): static
	{
		$this->visualizer = $visualizer;
		$visualizer->setStrategy($this);

		return $this;
	}

	public function get(): array
	{
		return $this->array;
	}

	public function sort(): static
	{
		$this->visualizer?->onSort();
		$this->run();
		$this->visualizer?->onSorted($this->length, $this->assignment, $this->comparison);

		return $this;
	}

	abstract public function run(): static;

	protected function needToSwap($indexFrom, $indexTo): bool
	{
		$this->comparison++;
		$this->visualizer->onCompare($indexFrom, $indexTo);
		$result = $this->compare($this->array[$indexFrom], $this->array[$indexTo]);
		$this->visualizer->onCompared($indexFrom, $indexTo, $result);

		return $result;
	}

	public function compare($one, $two): bool
	{
		return $one > $two;
	}

	public function swap(int $indexFrom, int $indexTo): void
	{
		$this->visualizer->onSwap($indexFrom, $indexTo);
		$this->assignment += 3;
		$buffer = $this->array[$indexFrom];
		$this->array[$indexFrom] = $this->array[$indexTo];
		$this->array[$indexTo] = $buffer;
		$this->visualizer->onSwapped($indexFrom, $indexTo);
	}
}
