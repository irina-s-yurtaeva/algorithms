<?php

namespace Otus;

class Timer
{
	protected int $timeout = 0;
	protected int $timeStart;

	public function __construct(int $timeout, int $timeStart = null)
	{
		$this->timeout = $timeout;
		$this->timeStart = ($timeStart ?? hrtime()[0]);
	}

	public function check(): bool
	{
		$currentTime = hrtime()[0];

		if (($currentTime - $this->timeStart) >= $this->timeout)
		{
			throw new \Otus\TimeoutException();
		}

		return true;
	}
}
