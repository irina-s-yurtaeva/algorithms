<?php

namespace Otus\ex30_DynamicProgramming;

use Otus\PaintUtils;
use Otus\Result;

class Islands extends \Otus\Alg
{
	public const CODE = '3';

	protected PaintUtils $painter;

	public function __construct()
	{
		$this->painter = new PaintUtils();
	}

	public function getName(): string
	{
		return 'Острова';
	}

	public function apply(): Result
	{
		$result = parent::apply(); // TODO: Change the autogenerated stub


		echo 'Дана квадратная матрица, состоящая из 0 и 1. Нужно найти к-во островов.
Остров - это одна или более единиц, которые соединены. Соединены - это значит, что они
соседи по вертикали или горизонтали. По диагонали единицы не соединяются.' . PHP_EOL;
		$size = readline('Размер поля: ');
		if ($size <= 0)
		{
			$size = 3;
			echo 'Были использованы демо-данные. ' . PHP_EOL;
			$matrix = $this->getDemoData();
		}
		else
		{
			$matrix = [];
			for ($i = 0; $i < $size; $i++)
			{
				for ($j = 0; $j < $size; $j++)
				{
					$matrix[$i][$j] = rand(0, 1);
				}
			}
		}

		[$count, $map] = $this->markIslands($matrix);

		echo 'Количество островов: ' . $count . PHP_EOL;

		for ($i = 1; $i <= $count; $i++)
		{
			$islands['island_' . $i] = [
				rand(0, 255),
				rand(0, 255),
				rand(0, 255),
			];
		}

		$elementSize = 3;
		$elementSizeX = 5;
		for ($i = 0; $i < count($map); $i++)
		{
			$s = $elementSize;
			while (--$s > 0)
			{
				for ($j = 0; $j < count($map); $j++)
				{
					if ($map[$i][$j] === 0)
					{
						echo str_repeat(' ', $elementSizeX);
					}
					else
					{

						echo $this->painter->drawUpperPixel($islands[$map[$i][$j]]);
						echo str_repeat(' ', $elementSizeX);
						echo $this->painter->resetColor();
					}
				}
				echo PHP_EOL;
			}
		}
		//endregion

		return $result;
	}

	protected function markIslands(array $map): array
	{
		$count = 0;
		for ($i = 0; $i < count($map); $i++)
		{
			for ($j = 0; $j < count($map); $j++)
			{
				if ($map[$i][$j] === 1)
				{
					$count++;
					$id = 'island_' . $count;
					$map = $this->dfs($map, $i, $j, $id);
				}
			}
		}
		return [
			$count,
			$map
		];
	}

	protected function dfs(array $map, int $i, int $j, string $id): array
	{
		if ($map[$i][$j] !== 1)
		{
			return $map;
		}

		$map[$i][$j] = $id;

		if ($i > 0)
		{
			$map = $this->dfs($map, $i - 1, $j, $id);
		}
		if ($i < count($map))
		{
			$map = $this->dfs($map, $i + 1, $j, $id);
		}
		if ($j > 0)
		{
			$map = $this->dfs($map, $i, $j - 1, $id);
		}
		if ($i < count($map))
		{
			$map = $this->dfs($map, $i, $j + 1, $id);
		}

		return $map;
	}

	protected function getDemoData(): array
	{
		return  [[1, 1, 0, 0], [1, 0, 0, 1], [1, 0, 1, 0], [0, 1, 1, 0]];
	}
}
