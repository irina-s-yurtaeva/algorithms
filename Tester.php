<?php

namespace Otus;

class Tester
{
	private string $path;
	private array $data;

	public function __construct(string $path)
	{
		$this->path = $path;
	}

	public function getData(): array
	{
		if (isset($this->data))
		{
			return $this->data;
		}

		$result = [];
		if (is_dir($this->path) && ($handle = opendir($this->path)))
		{
			echo "\n\n";
			while (($file = readdir($handle)) !== false)
			{
				if ($file == "." || $file == "..")
				{
					continue;
				}
				$inFile = $this->path . '/' . $file;
				if (is_file($inFile) && substr($inFile, -3, 3) === '.in')
				{
					$outFile = substr($inFile, 0, -3) . '.out';
					if (is_file($outFile))
					{
						$in = explode("\r\n", file_get_contents($inFile));
						$out = explode("\r\n", file_get_contents($outFile));
						$index = (int)preg_replace('/[^\d]+/', '', $file);
						$result[$index] = [$in, $out];
					}
				}
			}
			closedir($handle);
		}
		ksort($result);
		$this->data = $result;
		return $this->data;
	}
}