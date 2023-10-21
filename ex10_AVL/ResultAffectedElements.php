<?php

namespace Otus\ex10_AVL;

use Otus\Result;

class ResultAffectedElements extends Result
{
	private array $elements = [];
	private array $affectedElements = [];

	public function __construct($elements)
	{
		parent::__construct();
		$this->elements = $elements;
	}

	public function getElementsCount(): int
	{
		return count($this->elements);
	}

	public function addAffectedElement(Node | int $affectedElement): int
	{
		return $this->affectedElements[] = $affectedElement;
	}

	public function getAffectedElementsCount(): int
	{
		return count($this->affectedElements);
	}
}