<?php

namespace Otus\ex07_ExternalSort;

abstract class SortAlgs
{
	protected const TIMEOUT = 120;

	protected ?int $deltaTime;
	protected bool $interrupted = false;

	protected int $timeStart;
	protected int $timeFinish;

	public function sortFile(TestFile $file, string $outputFileName): static
	{
		$resultFile = $this->sort($file);
		$resultFile?->copy($outputFileName);

		return $this;
	}

	protected function checkTime(): bool
	{
		$this->timeFinish = hrtime()[0];

		if (($this->timeFinish - $this->timeStart) >= self::TIMEOUT)
		{
			throw new \Otus\TimeoutException();
		}

		return true;
	}

	public function sort(TestFile $rawFile): ?TestFile
	{
		$this->interrupted = false;
		$this->deltaTime = null;
		$this->timeStart = hrtime()[0];
		try
		{
			$resultFile = $this->run($rawFile);
		}
		catch(\Otus\TimeoutException)
		{
			$this->interrupted = true;
		}
		$this->timeFinish = hrtime()[0];
		$this->deltaTime = $this->timeFinish - $this->timeStart;

		return $resultFile ?? null;
	}

	abstract public function run(TestFile $rawFile): TestFile;

	public function getAnswer(): string
	{
		if ($this->interrupted === true)
		{
			return 'Interrupted with time: ' . round($this->deltaTime, 2);
		}
		else if ($this->deltaTime === null)
		{
			return 'Not finished';
		}

		return round($this->deltaTime, 2) . ' sec';
	}
}
