<?php

namespace Otus\ex10_AVL;

class VisitorDFSearcher extends Visitor
{
	protected Node $startNode;
	protected int $value;
	protected ?Node $foundNode;

	public function apply(Node $rootNode, int $value): ?Node
	{
		$this->startNode = $rootNode;
		$this->value = $value;
		$this->foundNode = null;
		$this->visit($rootNode);

		return $this->foundNode;
	}

	public function visit(?Node $node)
	{
		if ($node === null || $this->foundNode !== null)
		{
			return;
		}
		if ($node->getValue() === $this->value)
		{
			$this->foundNode = $node;
		}
		else if ($this->value < $node->getValue())
		{
			$this->visit($node->getLeft());
		}
		else
		{
			$this->visit($node->getRight());
		}
	}
}
