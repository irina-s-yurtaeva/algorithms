<?php

namespace Otus\ex27_Archiver;

class RLE2UnzipAlg extends ArchiverAlg
{
	public function getName(): string
	{
		return 'Run-length Enhanced decoding';
	}

	protected function convert(string $data): string
	{
		$result = '';
		$rawStr = $data;
		while (strlen($rawStr) > 0)
		{
			$offset = 1;
			[$countTimes] = array_values(unpack('c', $rawStr));

			if ($countTimes < 0)
			{
				$raw = unpack('C*', substr($rawStr, $offset, abs($countTimes)));
				$result .= implode('', array_map(fn($ord) => chr($ord), $raw));
				$offset += abs($countTimes);
			}
			else
			{
				$raw = unpack('C', substr($rawStr, $offset, 1));
				$letter = implode('', array_map(fn($ord) => chr($ord), $raw));
				$offset += 1;
				$result .= str_repeat($letter, $countTimes);
			}
			$rawStr = substr($rawStr, $offset);
			$this->iterate();
		}

		return $result;

	}
}
