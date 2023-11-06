<?php

namespace Otus\ex18_Vertex;

class VisitorDFSearcher extends Visitor
{
	protected array $visited = [];
	protected array $stack = [];
	protected bool $forwardOrder;

	public function __construct(bool $forwardOrder = true)
	{
		$this->forwardOrder = $forwardOrder;
	}

	public function visit(Vertex|Edge $node): void
	{
		$this->stack[] = $node;
		$this->visited[] = $node;
	}

	public function calc(Vertex|Edge $node): array
	{
		$this->stack = [];
		$this->dfs($node);

		return array_reverse($this->stack);
	}

	protected function dfs(Vertex $v)
	{
		if (in_array($v, $this->visited))
		{
			return;
		}

		$v->accept($this);

		if ($this->forwardOrder)
		{
			foreach ($v->getOutgoingEdges() as $edge)
			{
				$this->dfs($edge->getHead());
			}
		}
		else
		{
			foreach ($v->getIncomingEdges() as $edge)
			{
				$this->dfs($edge->getTail());
			}
		}
	}
}
