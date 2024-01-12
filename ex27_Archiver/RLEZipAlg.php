<?php

namespace Otus\ex27_Archiver;

use Otus\Result;

class RLEZipAlg extends ArchiverAlg
{
	public function getName(): string
	{
		return 'Run-length encoding';
	}

	protected function convert(string $data): string
	{
		$result = [];
		$letters = str_split($data);
		$letter = array_shift($letters);
		$pair = [$letter, 0];
		while ($letter)
		{
			if ($pair[0] === $letter)
			{
				$pair[1]++;
			}
			else
			{
				$result[] = [$pair[1], $pair[0]];
				$pair = [$letter, 1];
			}
			$this->iterate();
			$letter = array_shift($letters);
		}
		$result[] = [$pair[1], $pair[0]];

		$res = implode(PHP_EOL, array_map(fn($v) => pack('CC', $v[0], ord($v[1])), $result));
		return $res;
	}
}
