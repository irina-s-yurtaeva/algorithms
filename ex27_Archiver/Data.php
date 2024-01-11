<?php

namespace Otus\ex27_Archiver;

abstract class Data
{
	abstract public function save(): static;

	abstract public function set(string $data): ?static;

	abstract public function get(): ?string;

}
