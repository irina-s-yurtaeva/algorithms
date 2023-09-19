<?php

namespace Otus\ex06_SimpleSort;

class SortVisualizer implements ISortArray
{
	protected \Otus\PaintUtils $painter;
	protected ISortArray $strategy;

	public function __construct()
	{
		$this->painter = new \Otus\PaintUtils();
	}

	public function setStrategy(ISortArray $strategy): static
	{
		$this->strategy = $strategy;
		return $this;
	}

	public function sort(): static
	{
		echo 'before: ' . implode(', ', $this->strategy->get()). PHP_EOL;
		$this->strategy->sort();
		// Отрисовать массив
		return $this;
	}

	public function showInfo(): static
	{
		echo 'after: ' . implode(', ', $this->strategy->get()). PHP_EOL;

		$this->strategy->showInfo();
		// Вывести информацию
		return $this;
	}

	public function swap(int $indexFrom, int $indexTo): void
	{
		$this->strategy->swap($indexFrom, $indexTo);
		//Провести перестановку
	}
}
