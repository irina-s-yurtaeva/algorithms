<?php

namespace Otus\ex10_AVL;

class NodeSplay extends NodeBinary
{
	public function calibrateNode(Node $node): ?static
	{
		if ($node instanceof NodeSplay)
		{
			return $node;
		}

		return null;
	}


}
