<?php

namespace Otus;

class Result
{
	private array $timeStart;
	private array $timeFinish;
	private int $memoryStart;
	private int $memoryFinish;
	private ?array $data = null;

	public function __construct()
	{
		$this->timeStart = hrtime();
		$this->memoryStart = memory_get_usage();
	}

	public function getTimeStart(): int
	{
		return $this->timeStart[0];
	}

	public function finalize(): static
	{
		$this->timeFinish = hrtime();
		$this->memoryFinish = memory_get_usage();

		return $this;
	}

	public function isFinalized(): bool
	{
		return isset($this->timeFinish);
	}

	public function getTimeUsage(): string
	{
		if ($this->isFinalized())
		{
			$sec = $this->timeFinish[0] - $this->timeStart[0];

			if ($sec > 0)
			{
				return $sec . ' sec';
			}

			$base = 1000;
			$microSec = $this->timeFinish[1] - $this->timeStart[1];
			$power = max(ceil(log($microSec, $base)) - 1, 0);

			$value = round($microSec / $base ** $power, 2);

			$name = [0 => 'nanoS', 1 => 'microS', 2 => 'milliS'];

			return $value . ' ' . $name[$power];
		}

		return 'Not finished';
	}

	public function getMemoryUsage(): string
	{
		if ($this->isFinalized())
		{
			$memory = $this->memoryFinish - $this->memoryStart;
			$name = ['B', 'KB', 'MB', 'GB'];

			$base = 1024;
			$power = max(ceil(log($memory, $base)) - 1, 0);
			$value = round($memory / $base ** $power, 2);

			return $value . ' ' . $name[$power];
		}

		return 'Not finished';
	}

	public function setData(array $data): static
	{
		$this->data = $data;

		return $this;
	}

	public function getData(): ?array
	{
		return $this->data;
	}
}