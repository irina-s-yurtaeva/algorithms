<?php

namespace Otus\ex07_ExternalSort;

class Sieve
{
	/**
	 * @var TestFile[] $files
	 */

	protected array $files = [];
	protected array $workingFiles = [];
	protected ?int $lastValue = -1;

	public function __construct(array $files)
	{
		$this->files = $files;
	}

	public function getNext(): ?int
	{
		if (count($this->files) <= 0)
		{
			return null;
		}

		$result = null;
		$file = reset($this->files);
		while ($file)
		{
			if (!$file->valid() || $file->current() < $this->lastValue)
			{
				array_shift($this->files);
				$file = reset($this->files);
				continue;
			}

			if ($file->current() === $this->lastValue)
			{
				$file->next();
				$result = $this->lastValue;
				break;
			}

			if ($file->current() > $this->lastValue)
			{
				$this->lastValue = min(array_map(fn($f) => $f->current(), $this->files));
				while ($file = array_shift($this->files))
				{
					if ($file->current() === $this->lastValue)
					{
						array_unshift($this->files, $file);
						break;
					}
					$this->files[] = $file;
				}
			}
		}

		return $result;
	}
}
