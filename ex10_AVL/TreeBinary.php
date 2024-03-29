<?php

namespace Otus\ex10_AVL;

class TreeBinary extends Tree
{
	public function getName(): string
	{
		return 'Simple binary';
	}

	protected function createNode(mixed $value): Node
	{
		return new NodeBinary($value);
	}
}
