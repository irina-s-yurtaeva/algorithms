<?php

namespace Otus\ex18_Vertex;

class VisitorInverseDFSearcher extends Visitor
{
	protected array $visited = [];
	protected array $stack = [];

	public function visit(Vertex|Edge $node): Vertex
	{
		$this->stack[] = $node;
		$this->cookStack();

		return $node;
	}

	private function cookStack()
	{
		$v = array_pop($this->stack);
		$this->visited[] = $v;
		/* @var Vertex $v */
		$v->accept($this);
		/**
		 * @var $edge Edge
		 */
		foreach ($v->getOutgoingEdges() as $edge)
		{
			$edge->getHead()->getOutgoingEdges();
		}


	}
}
