<?php

namespace Otus\ex30_DynamicProgramming;

use Otus\PaintUtils;
use Otus\Result;

class EightFive extends \Otus\Alg
{
	public const CODE = '1';

	protected PaintUtils $painter;

	public function __construct()
	{
		$this->painter = new PaintUtils();
	}

	public function getName(): string
	{
		return 'Пятью восемь';
	}

	public function apply(): Result
	{
		$result = parent::apply();
		echo
			'Дано число N - это количество разрядов. Надо узнать, сколько N-значных чисел можно ' . PHP_EOL .
			'составить, используя числа 5 и 8, причем таких, что 3 одинаковых цифры подряд стоять не ' . PHP_EOL .
			'должны. ' . PHP_EOL .
			'85558 - нельзя' . PHP_EOL .
			'855855 - можно' . PHP_EOL
		;
		$range = readline('Порядок числа от 1 до 88: ');
		$range = min(!empty($range) ? $range : 4, 88);
echo '$range: '. $range . PHP_EOL;
		[$sum, $numbers] = $this->calc($range);
		echo 'Для порядка: ' . $range . ' ответ: ' . $sum . PHP_EOL;
		echo implode(', ', $numbers) . PHP_EOL;
		return $result;
	}

	protected function calc($range): array
	{
		$res = [
			'x5' => [1 => 1],
			'55' => [1 => 0],
			'x8' => [1 => 1],
			'88' => [1 => 0],
		];
		$container = [
			1 => [
				'x5' => [5],
				'55' => [],
				'x8' => [8],
				'88' => [],
			]
		];

		for ($i = 2; $i <= $range; $i++)
		{
			$res['x5'][$i] = $res['x8'][$i - 1] + $res['88'][$i - 1];
			$res['55'][$i] = $res['x5'][$i - 1];
			$res['x8'][$i] = $res['x5'][$i - 1] + $res['55'][$i - 1];
			$res['88'][$i] = $res['x8'][$i - 1];

			$container[$i] = [
					'x5' => [],
					'55' => [],
					'x8' => [],
					'88' => [],
				]
			;

			foreach (array_merge($container[$i - 1]['x8'], $container[$i - 1]['88']) as $item)
			{
				$container[$i]['x5'][] = $item . '5';
			}
			foreach ($container[$i - 1]['x5'] as $item)
			{
				$container[$i]['55'][] = $item . '5';
			}
			foreach (array_merge($container[$i - 1]['x5'], $container[$i - 1]['55']) as $item)
			{
				$container[$i]['x8'][] = $item . '8';
			}
			foreach ($container[$i - 1]['x8'] as $item)
			{
				$container[$i]['88'][] = $item . '8';
			}
		}

		return [
			$res['x5'][$range] + $res['55'][$range] + $res['x8'][$range] + $res['88'][$range],
			array_merge(
				$container[$range]['x5'],
				$container[$range]['55'],
				$container[$range]['x8'],
				$container[$range]['88'],
			)
		];
	}
}
