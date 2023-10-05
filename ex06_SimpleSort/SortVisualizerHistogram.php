<?php

namespace Otus\ex06_SimpleSort;

class SortVisualizerHistogram extends SortVisualizerAbstract
{
	protected \Otus\PaintUtils $painter;
	private int $vOffset = 1;
	private int $vTopGap = 1;
	private int $hOffset = 3;
	private float $scale;
	private const BACKGROUND_COLOR = [200, 20, 70];
	private const DEFAULT_COLOR = [20, 34, 70];
	private const COMPARE_COLOR = [223, 207, 190];
	private const FONT_COLOR = [255,255,255];
	private const SHIFT_COLOR = [69,184,172];
	private const DELAY = 5000;
	private const DEBUG = false;
	private int $workSpaceHeight = 10;


	public function __construct()
	{
		$this->painter = new \Otus\PaintUtils();
	}

	public function checkStrategy(\Otus\ex06_SimpleSort\SortAlgs $strategy): bool
	{
		if (count($strategy->get()) > $this->painter->termWidth/* || $strategy instanceof \Otus\ex06_SimpleSort\SortInsertionWithAShift*/)
		{
			return false;
		}
		$max = max($strategy->get());
		if (is_int($max) || is_float($max))
		{
			return true;
		}
		return false;
	}

	public function setStrategy(\Otus\ex06_SimpleSort\SortAlgs $strategy): static
	{
		parent::setStrategy($strategy);
		$max = max($strategy->get());
		$this->scale = 1;
		if ((is_int($max) || is_float($max)) && $this->workSpaceHeight < $max)
		{
			$this->scale = round($this->workSpaceHeight / $max, 3);
		}
		return $this;
	}

	public function setHeight(int $heightInLines): static
	{
		$this->workSpaceHeight = $heightInLines;
		return $this;
	}

	public function onSort(): void
	{
		// TODO Calc vertical scale
		echo $this->strategy::class . ':'. PHP_EOL;

		$this->drawHistogram();
		parent::onSort();

	}

	public function onSorted(int $length, int $assigment,int $comparisson): void
	{
		$timeResult = (microtime(true) - $this->timestamp) * 1000000;
		echo  str_pad('Size: ' . $length, 10)
			. ' | Assigments: ' . str_pad($assigment, 10)
			. ' | Comparissons: ' . str_pad($comparisson, 13)
			. ' | Time: ' . str_pad(round($timeResult), 10) . PHP_EOL . PHP_EOL
		;
	}

	public function onTimeExpired(int $length): void
	{
		echo ' Size: ' . str_pad($length, 10)
			. ' Interrupted!!!' . PHP_EOL . PHP_EOL
		;
	}

	private function drawHistogram()
	{
		for ($i = 0; $i < ($this->workSpaceHeight + $this->vOffset + $this->vTopGap); $i++)
		{
			$x = $this->workSpaceHeight - $i + $this->vTopGap;
			echo $this->painter->drawChar(
					self::BACKGROUND_COLOR, [255, 0, 255],
					str_pad(0 < $x && $x <= $this->workSpaceHeight ? $x : ' ', $this->hOffset - 1, ' ', STR_PAD_LEFT)
					. '|' . str_repeat(' ', $this->painter->termWidth - $this->hOffset),
					false
				) . $this->painter::RESET_COLOR_AND_NEW_LINE
			;
		}

//		echo "\e7"; //Сохраняем курсор
		echo "\e[s"; //Сохраняем курсор
		if (self::DEBUG)
		{
			echo $this->painter->drawChar(
				$color ?? self::DEFAULT_COLOR, [255, 255, 0], 'S', false
			);
			sleep(1);
			echo "\e[" . ($this->vOffset + 1). "F\e[" . $this->hOffset. "C"; //Сместиться вверх на вертикальное смещение, вправо на горизонтальное.
			echo $this->painter->drawChar(
				$color ?? self::DEFAULT_COLOR, [0, 255, 255], '+', false
			);
			sleep(1);
		}
		echo "\e[u"; //Восстанавливает курсор
		foreach ($this->strategy->get() as $number => $value)
		{
			$this->drawHistogramVerticalLine($number, $value);

//			echo "\e8"; //Восстанавливает курсор
			echo "\e[u"; //Восстанавливает курсор через CSI-последовательности
		}
	}

	private function setCursorTo(int $row, ?int $cell = null): void
	{
		// Перейти в начало координат. Это начальная точка.
		echo "\e[" . ($this->vOffset) . "F";//Сместиться вверх на вертикальное смещение в первый столбец в строке
		echo "\e[" . $this->hOffset . "C"; //Сместиться  вправо на горизонтальное смещение, не меняя строки.
		// Теперь смещаемся на нужную линию гистограммы
		$xPosition = $row + 1; // отсчет в CSI-последовательностях с 1 всегда. Т.е. 0 = 1 :(

		echo "\e[" . $xPosition . "C"; // переместить вправо на x

		if (!empty($cell))
		{
			echo "\e[" . $cell . "C";
		}
	}

	private function drawHistogramVerticalLine(int $lineNumber, int $high, ?array $color = null): void
	{
		$workingColor = $color ?? self::DEFAULT_COLOR;

		$this->setCursorTo($lineNumber);
		$startNumber = 1;
		if ($high === 0)
		{
			echo "\e[1D"; // переместить на 1 влево
			echo "\e[1A"; // переместить на 1 вверх
			echo $this->painter->drawChar(
				self::BACKGROUND_COLOR, $workingColor,
				'_',
				false
			);
			$startNumber = 2;
		}
		$scaledHeight = ceil($high * $this->scale);
		for ($i = $startNumber; $i <= $this->workSpaceHeight; $i++)
		{
			echo "\e[1D"; // переместить на 1 влево
			echo "\e[1A"; // переместить на 1 вверх

			echo $this->painter->drawChar(
				$i <= $scaledHeight ? $workingColor : self::BACKGROUND_COLOR, self::FONT_COLOR,
				' ',
				false
			);
		}

		echo "\e[u"; //Восстанавливает курсор, который д.б. сохранён выше по ф-ции.

		// Null value has not been drawn so lets fix it
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
			$this->drawHistogramVerticalLine($x, $high, $color);
		}

		usleep($this::DELAY);

		if (!$result)
		{
			foreach ([
				[$indexFrom, $this->strategy->get()[$indexFrom], self::DEFAULT_COLOR],
				[$indexTo, $this->strategy->get()[$indexTo], self::DEFAULT_COLOR],

			] as [$x, $high, $color])
			{
				$this->drawHistogramVerticalLine($x, $high, $color);
			}
			usleep($this::DELAY);
		}
	}

	public function onSwap(int $indexFrom, int $indexTo): void
	{
		echo "\e[s"; //Сохраняем курсор
		foreach ([
			[$indexFrom, $this->strategy->get()[$indexTo], self::DEFAULT_COLOR],
			[$indexTo, $this->strategy->get()[$indexFrom], self::DEFAULT_COLOR],
		] as [$x, $high, $color])
		{
			$this->drawHistogramVerticalLine($x, $high);
		}

		usleep($this::DELAY);
	}

	public function onSwapped(int $indexFrom, int $indexTo): void
	{

	}

	public function onSelect(int $indexFrom, int $indexTo): void
	{
		echo "\e[s"; //Сохраняем курсор
		for ($i = $indexFrom; $i <= $indexTo; $i++)
		{
			$this->drawHistogramVerticalLine($i, $this->strategy->get()[$i], self::SHIFT_COLOR);
		}

		usleep($this::DELAY);
	}

	public function onDeselect(int $indexFrom, int $indexTo): void
	{
		echo "\e[s"; //Сохраняем курсор
		for ($i = $indexFrom; $i <= $indexTo; $i++)
		{
			$this->drawHistogramVerticalLine($i, $this->strategy->get()[$i], self::DEFAULT_COLOR);
		}

		usleep($this::DELAY);
	}
}
