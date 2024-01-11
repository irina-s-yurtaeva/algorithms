<?php

namespace Otus\ex27_Archiver;

class DataText extends Data
{
	protected string $inputData;

	public function save(): static
	{
		return $this;
	}

	public function set(string $data): ?static
	{
		$this->inputData = $data;

		return $this;
	}

	public function get(): ?string
	{
		return $this->inputData;
	}
}
