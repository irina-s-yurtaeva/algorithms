<?php

namespace Otus\ex27_Archiver;

class RLE2ZipAlg extends ArchiverAlg
{
	public function getName(): string
	{
		return 'Run-length Enhanced encoding';
	}

	protected function convert(string $data): string
	{
		$result = [];
		$letters = str_split($data);
		$pair = [null, 0];
		$buff = [];
		while ($letter = array_shift($letters))
		{
			if ($pair[0] === $letter)
			{
				array_pop($buff);
				if (!empty($buff))
				{
					$result[] = [-count($buff), $buff];
					$buff = [];
				}
				elseif ($pair[1] >= 127)
				{
					$result[] = [$pair[1], [$pair[0]]];
					$pair[1] = 0;
				}
				$pair[1]++;
			}
			else
			{
				if ($pair[1] > 1)
				{
					$result[] = [$pair[1], [$pair[0]]];
					$buff = [];
				}
				$pair = [$letter, 1];
			}
			$buff[] = $letter;

			$this->iterate();
		}
		if ($pair[1] > 1)
		{
			$result[] = [$pair[1], [$pair[0]]];
		}
		else if (!empty($buff))
		{
			$result[] = [-count($buff), $buff];
		}

		return $this->pack($result);
	}

	protected function pack(array $parts): string
	{
		$res = [];
		$res2 = [];

		foreach ($parts as [$countTimes, $letters])
		{
			$res[] = implode(' ', [$countTimes, implode('', $letters)]);
			$res2[] = pack('c', $countTimes)
				.implode('', array_map(fn($v) => pack('C', ord($v)), $letters))
			;

		}
/*		?><pre><b>$res: </b><?php print_r($res)?></pre><?php
		?><pre><b>$res2: </b><?php print_r($res2)?></pre><?php
*/
		return implode('', $res2);
	}
}
