<?php

namespace Otus\ex27_Archiver;

use Otus\Result;

class HuffmanUnzipAlg extends ArchiverAlg
{
	public function getName(): string
	{
		return 'Huffman decoding';
	}

	protected function convert(string $data): string
	{
		$result = '';
		$rawStr = strtok($data, $token = PHP_EOL);
		while ($rawStr)
		{
			[$countTimes, $ordLetter] = explode(' ', $rawStr);
			$result .= str_repeat(chr($ordLetter), $countTimes);
			$rawStr = strtok($token);
			$this->iterate();
		}

		return $result;
	}
}
