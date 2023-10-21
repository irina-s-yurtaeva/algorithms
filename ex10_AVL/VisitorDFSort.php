<?php

namespace Otus\ex10_AVL;

class VisitorDFSort extends Visitor
{
	protected Node $startNode;
	protected array $sortedArray;

	public function apply(Node $rootNode): array
	{
		$this->startNode = $rootNode;
		$this->sortedArray = [];
		$this->visit($rootNode);

		return $this->sortedArray;
	}

	public function visit(?Node $node)
	{
		if ($node === null)
		{
			return;
		}

		$this->visit($node->getLeft());
		$this->sortedArray[] = $node->getValue();
		$this->visit($node->getRight());
	}
}
