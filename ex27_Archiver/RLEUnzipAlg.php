<?php

namespace Otus\ex27_Archiver;

class RLEUnzipAlg extends ArchiverAlg
{
	public function getName(): string
	{
		return 'Run-length decoding';
	}

	protected function convert(string $data): string
	{
		$result = '';
		$rawStr = strtok($data, $token = PHP_EOL);
		while ($rawStr)
		{
			[$countTimes, $ordLetter] = array_values(unpack('C*', $rawStr));
			$result .= str_repeat(chr($ordLetter), $countTimes);
			$rawStr = strtok($token);
			$this->iterate();
		}

		return $result;
	}
}
