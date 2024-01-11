<?php

namespace Otus\ex27_Archiver;

use Otus\Alg;
use Otus\Result;

abstract class ArchiverAlg extends Alg
{
	protected Data $data;

	public function setData(Data $data): static
	{
		$this->data = $data;

		return $this;
	}

	public function getData(): Data
	{
		return $this->data;
	}

	public function apply(): Result
	{
		$result = parent::apply();

		$output = clone $this->data;
		$output->set($this->convert($this->data->get()));

		$result->finalize();
		$result->setData([$output]);

		return $result;
	}

	abstract protected function convert(string $data): string;
}
