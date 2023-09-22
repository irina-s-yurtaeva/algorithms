<?php

namespace Otus\ex06_SimpleSort;

abstract class SortVisualizerAbstract
{
	protected ?SortAlgs $strategy = null;

	public function setStrategy(\Otus\ex06_SimpleSort\SortAlgs $strategy): static
	{
		$this->strategy = $strategy;
		return $this;
	}

	public function onSort(): void
	{
		echo $this->strategy::class . ' before: ' . implode(', ', $this->strategy?->get()). PHP_EOL;
	}

	public function onSorted(): void
	{
		echo $this->strategy::class . ' after: ' . implode(', ', $this->strategy?->get()). PHP_EOL;
	}

	abstract public function onCompare(int $indexFrom, int $indexTo): void;

	abstract public function onCompared(int $indexFrom, int $indexTo, bool $result): void;

	abstract public function onSwap(int $indexFrom, int $indexTo): void;

	abstract public function onSwapped(int $indexFrom, int $indexTo): void;
}
