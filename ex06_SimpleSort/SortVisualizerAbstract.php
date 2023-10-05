<?php

namespace Otus\ex06_SimpleSort;

abstract class SortVisualizerAbstract
{
	protected ?SortAlgs $strategy = null;
	protected ?float $timestamp = null;

	public function setStrategy(\Otus\ex06_SimpleSort\SortAlgs $strategy): static
	{
		$this->strategy = $strategy;
		return $this;
	}

	public function checkStrategy(\Otus\ex06_SimpleSort\SortAlgs $strategy): bool
	{
		return true;
	}

	public function onSort(): void
	{
		$this->timestamp = microtime(true);
	}

	abstract public function onSorted(int $length, int $assigment,int $comparisson): void;

	abstract public function onTimeExpired(int $length): void;

	abstract public function onCompare(int $indexFrom, int $indexTo): void;

	abstract public function onCompared(int $indexFrom, int $indexTo, bool $result): void;

	abstract public function onSwap(int $indexFrom, int $indexTo): void;

	abstract public function onSwapped(int $indexFrom, int $indexTo): void;

	abstract public function onSelect(int $indexFrom, int $indexTo): void;

	abstract public function onDeselect(int $indexFrom, int $indexTo): void;
}
