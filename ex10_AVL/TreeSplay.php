<?php

namespace Otus\ex10_AVL;

class TreeSplay extends TreeBinary
{
	public function getName(): string
	{
		return 'Splay tree';
	}

	protected function createNode(mixed $value): Node
	{
		return new NodeSplay($value);
	}
}
