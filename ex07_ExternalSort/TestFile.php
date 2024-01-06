<?php

namespace Otus\ex07_ExternalSort;

class TestFile implements \Iterator
{
	private static array $instances = [];
	private int $stringsCount = 0;
	private string $fileName;
	private $fileSource;
	private ?int $filePointer = null;
	private array $filePointerSteps = [];

	public function __construct(string $fileName = null)
	{
		$this->fileName = $fileName;
	}

	public function getLength(): int
	{
		return $this->stringsCount;
	}

	protected function getFileToRead()
	{
		if (!isset($this->fileSource))
		{
			$this->fileSource = fopen($this->fileName, "r");
		}

		return $this->fileSource;
	}

	public function current(): mixed
	{
		if ($file = $this->getFileToRead())
		{
			fseek($file, $this->filePointer);
			if ($res = fgets($file))
			{
				return intval(trim($res));
			}
		}

		$this->filePointer = null;
		return null;
	}

	public function next(): void
	{
		if (($file = $this->getFileToRead()) && $this->filePointer !== null)
		{
			fseek($file, $this->filePointer);
			$this->filePointerSteps[] = $this->filePointer;

			$res = fgets($file);

			if ($res === false || feof($file))
			{
				$this->filePointer = null;
			}
			else
			{
				$this->filePointer = ftell($file);
			}
		}
	}

	public function key(): ?int
	{
		return $this->filePointer;
	}

	public function valid(): bool
	{
		return $this->filePointer !== null;
	}

	public function rewind(): void
	{
		$this->filePointer = null;
		$this->filePointerSteps = [];
		if ($file = $this->getFileToRead())
		{
			rewind($file);
			$this->filePointer = 0;
		}
	}

	public function getData(int $count = 1000): ?array
	{
		if ($file = $this->getFileToRead())
		{
			rewind($file);
			fseek($file, $this->filePointer);
			$result = [];
			while (--$count >= 0 && !feof($file))
			{
				if ($res = fgets($file))
				{
					$result[] = intval(trim($res));
				}
			}
			$this->filePointer = ftell($file);
			if ($count > 0)
			{
				fclose($this->fileSource);
				unset($this->fileSource);
				$this->filePointer = 0;
			}

			return empty($result) ? null : $result;
		}

		return null;
	}

	public function fill(int $stringsLeft, ?int $range = 1000): static
	{
		if (!($fp = fopen($this->fileName, 'w')))
		{
			throw new \Exception('File ' . $this->fileName . ' was not created.');
		}

		$baseSet = range(1, $range);
		while ($stringsLeft > 0)
		{
			$length = min($stringsLeft, 1000000);
			shuffle($baseSet);
			$set = array_slice($baseSet, 0, $length);
			fwrite($fp, implode(PHP_EOL, $set) . PHP_EOL);
			$this->stringsCount += count($set) + 1;
			$stringsLeft -= count($set);
		}
		fclose($fp);

		return $this;
	}

	public function clean()
	{
		if (!($fp = fopen($this->fileName, 'w')))
		{
			throw new \Exception('File was not created.');
		}
		fclose($fp);
	}

	public function add(mixed $string): static
	{
		if (!($fp = fopen($this->fileName, 'a')))
		{
			throw new \Exception('File was not created.');
		}

		fwrite($fp, (is_array($string) ? implode(PHP_EOL, $string) : $string) . PHP_EOL);
		$this->stringsCount += (is_array($string) ? count($string) : 0) + 1;
		fclose($fp);

		return $this;
	}


	public function copy(string $newFileName): bool
	{
		return copy($this->fileName, $newFileName);
	}

	public static function generate(string $fileNameTemplate, int $stringsCount, int $range): static
	{
		return (new static($fileNameTemplate))->fill($stringsCount, $range);
	}

	public static function getInstanceForTheTest(string $fileName, int $stringsCount = 100, int $range = 0): static
	{
		if (isset(self::$instances[$fileName]))
		{
			return self::$instances[$fileName];
		}

		$file = new TestFile($fileName);
		if (!file_exists($fileName))
		{
			$file->fill($stringsCount, $range);
		}
		self::$instances[$fileName] = $file;

		return self::$instances[$fileName];
	}
}
