<?php

namespace Otus\ex06_SimpleSort;

class SortVisualizer implements ISortArray
{
	protected \Otus\PaintUtils $painter;
	protected SortAlgs$strategy;
	private int $vOffset = 2;
	private int $hOffset = 3;
	private const BACKGROUND_COLOR = [200, 20, 70];
	private const DEFAULT_COLOR = [20, 34, 70];
	private const COMPARE_COLOR = [];
	private const SWAP_COLOR = [];


	public function __construct()
	{
		$this->painter = new \Otus\PaintUtils();
	}

	public function getPainter(): \Otus\PaintUtils
	{
		return $this->painter;
	}

	public function setStrategy(SortAlgs $strategy): static
	{
		$this->strategy = $strategy;
		$this->drawHistogram();
		return $this;
	}

	private function drawHistogram()
	{
		foreach ($this->strategy->get() as $number => $value)
		{
			echo $this->painter->drawChar(
				self::BACKGROUND_COLOR, [255,255,255], str_repeat(' ', $this->painter->termWidth), false
				) . $this->painter::RESET_COLOR_AND_NEW_LINE;
		}

		for ($i = 0; $i < $this->vOffset; $i++)
		{
			echo $this->painter->drawChar(
					self::BACKGROUND_COLOR, [255,255,255], str_repeat(' ', $this->painter->termWidth), false
				) . $this->painter::RESET_COLOR_AND_NEW_LINE;
		}

		foreach ($this->strategy->get() as $number => $value)
		{
			echo "\e7"; //Сохраняем курсор

			echo "\e[" . ($this->vOffset + 1). "F\e[" . $this->hOffset. "C"; //Сместиться вверх на вертикальное смещение, вправо на горизонтальное.
			// Это начальная точка.
			// TODO: Как здесь запомнить позицию курсора, чтобы всегда на него переводить позицию?

			$number++;

			$this->drawHistogramVerticalLine($number, $value);

			echo "\e8";
		}
	}

	private function drawHistogramVerticalLine(int $xPosition, int $high, ?array $color = null)
	{
		echo "\e[" .$xPosition. "C"; // переместить вправо на x
		for ($i = 1; $i <= $high; $i++)
		{
			echo "\e[1D"; // переместить на 1 влево

			echo $this->painter->drawChar(
				$color ?? self::DEFAULT_COLOR, [255,255,0], ' '
			);
			echo "\e[1A"; // переместить на 1 вверх
		}
	}

	public function sort(): static
	{
		echo static::class . ' before: ' . implode(', ', $this->strategy->get()). PHP_EOL;
		$this->strategy->sort();
		// Отрисовать массив
		return $this;
	}

	public function showInfo(): static
	{
		echo static::class . ' after: ' . implode(', ', $this->strategy->get()). PHP_EOL;

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
