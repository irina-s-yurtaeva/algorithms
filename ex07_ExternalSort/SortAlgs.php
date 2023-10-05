<?php

namespace Otus\ex07_ExternalSort;

abstract class SortAlgs
{
	protected const TIMEOUT = 20;

	protected int $comparison = 0;
	protected int $assignment = 0;

	protected int $timeStart;
	protected int $timeFinish;

	public function sortFile(TestFile $file, string $outputFileName): static
	{
		$resultFile = $this->sort($file);
		$resultFile->copy($outputFileName);

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

	public function sort(TestFile $rawFile): TestFile
	{
		$this->timeStart = hrtime()[0];
//		try
//		{
			$resultFile = $this->run($rawFile);
			$this->timeFinish = hrtime()[0];
//		}
//		catch(\Otus\TimeoutException $exception)
//		{
//
//		}

		return $resultFile;
	}

	abstract public function run(TestFile $rawFile): TestFile;
}
