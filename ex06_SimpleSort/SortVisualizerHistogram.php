<?php

namespace Otus\ex06_SimpleSort;

class SortVisualizerHistogram extends SortVisualizerAbstract
{
	protected \Otus\PaintUtils $painter;
	private int $vOffset = 2;
	private int $hOffset = 3;
	private const BACKGROUND_COLOR = [200, 20, 70];
	private const DEFAULT_COLOR = [20, 34, 70];
	private const COMPARE_COLOR = [138, 180, 235];
	private const SWAP_COLOR = [];
	private const DELAY = 5000;


	public function __construct()
	{
		$this->painter = new \Otus\PaintUtils();
	}

	public function onSort(): void
	{
		$this->drawHistogram();
		parent::onSort();
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
//		echo "\e7"; //Сохраняем курсор
		echo "\e[s"; //Сохраняем курсор

		foreach ($this->strategy->get() as $number => $value)
		{
			echo "\e[" . ($this->vOffset + 1). "F\e[" . $this->hOffset. "C"; //Сместиться вверх на вертикальное смещение, вправо на горизонтальное.
			// Это начальная точка.
			// TODO: Как здесь запомнить позицию курсора, чтобы всегда на него переводить позицию?

			$number++;

			$this->drawHistogramVerticalLine($number, $value);

//			echo "\e8"; //Восстанавливает курсор
			echo "\e[u"; //Восстанавливает курсор
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

	public function onCompare(int $indexFrom, int $indexTo): void
	{

	}

	public function onCompared(int $indexFrom, int $indexTo, bool $result): void
	{
		echo "\e[s"; //Сохраняем курсор
		foreach ([
			[$indexFrom, $this->strategy->get()[$indexFrom], self::COMPARE_COLOR],
			[$indexTo, $this->strategy->get()[$indexTo], self::COMPARE_COLOR],

		] as [$x, $high, $color])
		{
			echo "\e[" . ($this->vOffset + 2). "F\e[" . $this->hOffset. "C"; //Сместиться вверх на вертикальное смещение, вправо на горизонтальное.
			$this->drawHistogramVerticalLine($x + 1, $high, $color);
			echo "\e[u"; //Восстанавливает курсор
		}

		usleep($this::DELAY);

		if (!$result)
		{
			foreach ([
				[$indexFrom, $this->strategy->get()[$indexFrom], self::DEFAULT_COLOR],
				[$indexTo, $this->strategy->get()[$indexTo], self::DEFAULT_COLOR],

			] as [$x, $high, $color])
			{
				echo "\e[" . ($this->vOffset + 2). "F\e[" . $this->hOffset. "C"; //Сместиться вверх на вертикальное смещение, вправо на горизонтальное.
				$this->drawHistogramVerticalLine($x + 1, $high, $color);
				echo "\e[u"; //Восстанавливает курсор
			}
			usleep($this::DELAY);
		}
	}

	public function onSwap(int $indexFrom, int $indexTo): void
	{
		echo "\e[s"; //Сохраняем курсор
		foreach ([
			[$indexFrom, $this->strategy->get()[$indexFrom], self::BACKGROUND_COLOR],
			[$indexFrom, $this->strategy->get()[$indexTo], self::DEFAULT_COLOR],
			[$indexTo, $this->strategy->get()[$indexTo], self::BACKGROUND_COLOR],
			[$indexTo, $this->strategy->get()[$indexFrom], self::DEFAULT_COLOR],
		] as [$x, $high, $color])
		{
			echo "\e[" . ($this->vOffset + 2). "F\e[" . $this->hOffset. "C"; //Сместиться вверх на вертикальное смещение, вправо на горизонтальное.
			$this->drawHistogramVerticalLine($x + 1, $high, $color);
			echo "\e[u"; //Восстанавливает курсор
		}

		usleep($this::DELAY);
	}

	public function onSwapped(int $indexFrom, int $indexTo): void
	{

	}
}
