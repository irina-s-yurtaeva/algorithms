<?php
namespace Otus\LuckyTickets;

class LoopSolverForSix
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
							for ($sixth = 0;  $sixth < 10; $sixth++)
							{
								if (($first + $second + $third) === ($fourth + $fifth + $sixth))
								{
									$count++;
								}
							}
						}
					}
				}
			}
		}

		return $count;
	}
}