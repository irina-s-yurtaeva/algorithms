<?php

namespace Otus;

abstract class Alg
{
	abstract public function getName(): string;

	abstract public function apply(): Result;
}