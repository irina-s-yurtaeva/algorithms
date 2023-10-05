<?php

namespace Otus\ex06_SimpleSort;

abstract class SortAlgs
{
	protected const TIMEOUT = 20;
	protected array $array = [];
	protected int $length = 0;
	protected int $comparison = 0;
	protected int $assignment = 0;
	protected int $timeStart;
	protected int $timeFinish;
	protected ?SortVisualizerAbstract $visualizer = null;

	public function setArray(array $array): static
	{
		$this->array = $array;
		$this->length = count($array);

		return $this;
	}

	protected function checkTime(): bool
	{
		$this->timeFinish = hrtime()[0];

		if (($this->timeFinish - $this->timeStart) >= self::TIMEOUT)
		{
			throw new Exception\SortTimeoutException();
		}

		return true;
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
		$this->timeStart = hrtime()[0];
		$this->visualizer?->onSort();
		try
		{
			$this->run();
			$this->timeFinish = hrtime()[0];
			$this->visualizer?->onSorted(
				$this->length,
				$this->assignment,
				$this->comparison
			);
		}
		catch(Exception\SortTimeoutException $exception)
		{
			$this->visualizer?->onTimeExpired(
				$this->length
			);
		}

		return $this;
	}

	abstract public function run(): static;

	protected function needToSwap($indexFrom, $indexTo): bool
	{
		$this->comparison++;
		$this->visualizer?->onCompare($indexFrom, $indexTo);
		$result = $this->compare($this->array[$indexFrom], $this->array[$indexTo]);
		$this->visualizer?->onCompared($indexFrom, $indexTo, $result);

		return $result;
	}

	public function compare($one, $two): bool
	{
		return $one > $two;
	}

	public function swap(int $indexFrom, int $indexTo): void
	{
		$this->visualizer?->onSwap($indexFrom, $indexTo);
		$this->assignment += 3;
		$buffer = $this->array[$indexFrom];
		$this->array[$indexFrom] = $this->array[$indexTo];
		$this->array[$indexTo] = $buffer;
		$this->visualizer?->onSwapped($indexFrom, $indexTo);
	}
}
