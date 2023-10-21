<?php

namespace Otus;

class Result
{
	private int $timeStart;
	private int $timeFinish;
	private int $memoryStart;
	private int $memoryFinish;
	private ?array $data = null;

	public function __construct()
	{
		$this->timeStart = hrtime()[0];
		$this->memoryStart = memory_get_usage();
	}

	public function getTimeStart(): int
	{
		return $this->timeStart;
	}

	public function finalize(): static
	{
		$this->timeFinish = hrtime()[0];
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
			return round($this->timeFinish - $this->timeStart, 2) . ' sec';
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