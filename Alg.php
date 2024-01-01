<?php

namespace Otus;

abstract class Alg
{
	abstract public function getName(): string;

	abstract public function apply(): Result;

	abstract public function getStats(): string;
}