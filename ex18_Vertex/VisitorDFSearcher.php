<?php

namespace Otus\ex18_Vertex;

class VisitorDFSearcher extends Visitor
{
	protected array $visited = [];
	protected array $stack = [];
	protected bool $forwardOrder;
	protected bool $recursionWay = false;

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
		// Just for fun
		if ($this->recursionWay === true)
			$this->recurse($node);
		else
			$this->iterate($node);

		return array_reverse($this->stack);
	}

	protected function iterate(Vertex $vInput): void
	{
		$iterationStack = [$vInput];

		while (!empty($iterationStack))
		{
			$v = array_pop($iterationStack);
			if (in_array($v, $this->visited))
			{
				continue;
			}

			$v->accept($this);

			if ($this->forwardOrder)
			{
				foreach ($v->getOutgoingEdges() as $edge)
				{
					if (!in_array($edge->getHead(), $this->visited))
					{
						array_push($iterationStack, $edge->getHead());
					}
				}
			}
			else
			{
				foreach ($v->getIncomingEdges() as $edge)
				{
					if (!in_array($edge->getTail(), $this->visited))
					{
						array_push($iterationStack, $edge->getTail());
					}
				}
			}
		}
	}

	protected function recurse(Vertex $v): void
	{
		if (in_array($v, $this->visited))
		{
			return;
		}

		$v->accept($this); // === $visitor->visit($this)

		if ($this->forwardOrder)
		{
			foreach ($v->getOutgoingEdges() as $edge)
			{
				$this->recurse($edge->getHead());
			}
		}
		else
		{
			foreach ($v->getIncomingEdges() as $edge)
			{
				$this->recurse($edge->getTail());
			}
		}
	}
}
