<?php

namespace Otus\ex10_AVL;

class TreeAVL extends Tree
{
	public function getName(): string
	{
		return 'Adelson-Velsky & Longdis';
	}

	protected function createNode(mixed $value): Node
	{
		return new NodeAVL($value);
	}
}
