<?php

namespace Otus\ex20_MinimumSpanningTree;

use Otus\ex18_Vertex\Graph;
use Otus\ex18_Vertex\Vertex;
use Otus\ex18_Vertex\Edge;
use Otus\Result;

class KraskalaAlg
{
	protected Graph $graph;

	public function __construct(Graph $graph)
	{
		$this->graph = $graph;
	}

	public function getName(): string
	{
		return 'Josef Kraskala (1956)';
	}

	/**
	 * @return Graph
	 */
	public function getGraph(): Graph
	{
		return $this->graph;
	}

	protected function unite(Vertex $v, Vertex $union)
	{
		$v->parent = $union;
	}

	protected function findMain(Vertex $v): Vertex
	{
		while ($v->parent !== $v)
		{
			$v = $v->parent;
		}

		return $v;
	}

	public function apply(): Result
	{
		$result = new Result();

		foreach ($this->graph->getVertices() as /** @var Vertex $v */ $v)
		{
			$v->parent = $v;
		}

		$edges = $this->graph->getEdges();
		uasort($edges, fn(Edge $e1, Edge $e2) => $e1->getWeight() > $e2->getWeight());
		$weight = 0;
		foreach ($edges as /** @var Edge $e */$e)
		{
			$mainTail = $this->findMain($e->getTail());
			$mainHead = $this->findMain($e->getHead());
			if ($mainTail !== $mainHead)
			{
				$this->unite($mainTail, $mainHead);
				$weight += $e->getWeight();
			}
		}

		$result->setData([$weight]);
		$result->finalize();
		return $result;
	}

}