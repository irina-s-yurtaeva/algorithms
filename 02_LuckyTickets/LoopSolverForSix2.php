<?php
namespace Otus\LuckyTickets;

class LoopSolverForSix2
{
	public static function calculate(): int
	{
		$count = 0;
		for ($first = 0; $first < 10; $first++)
		{
			for ($second = 0; $second < 10; $second++)
			{
				for ($third = 0; $third < 10; $third++)
				{
					for ($fourth = 0; $fourth < 10; $fourth++)
					{
						for ($fifth = 0; $fifth < 10; $fifth++)
						{
							$difference = ($first + $second + $third) - ($fourth + $fifth);
							if ($difference >= 0 && $difference <= 9)
							{
								$count++;
							}
						}
					}
				}
			}
		}

		return $count;
	}
}