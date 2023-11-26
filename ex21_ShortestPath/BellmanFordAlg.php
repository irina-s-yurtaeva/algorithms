<?php

namespace Otus\ex21_ShortestPath;

use Otus\ex18_Vertex\Graph;
use Otus\ex18_Vertex\Vertex;
use Otus\ex18_Vertex\Edge;
use Otus\Result;

class BellmanFordAlg
{
	protected Graph $graph;

	public function __construct(Graph $graph)
	{
		$this->graph = $graph;
	}

	public function getName(): string
	{
		return 'Richard Bellman & Lester Ford (1956)';
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
		$resultMatrix = $this->graph->getPathMatrix();
		$result = new Result();
		/* @var Vertex $s */
		foreach ($this->graph->getVertices() as $s)
		{
			$bellmanFordMatrix = [1 => $resultMatrix[$s->getId()]];

			for ($i = 2; $i < count($this->graph->getVertices()); $i++)
			{
				$bellmanFordMatrix[$i] = $bellmanFordMatrix[$i - 1];
				/* @var Edge $edge */
				foreach ($this->graph->getEdges() as $edge)
				{
					if ($s->getId() === $edge->getHead()->getId() ||
						$s->getId() === $edge->getTail()->getId())
					{
						continue;
					}

					$current = $bellmanFordMatrix[$i][$edge->getTail()->getId()];
					if ($bellmanFordMatrix[$i][$edge->getHead()->getId()] !== null)
					{
						$possible = $bellmanFordMatrix[$i][$edge->getHead()->getId()] + $edge->getWeight();

						if ($current === null || $possible < $current)
						{
							$bellmanFordMatrix[$i][$edge->getTail()->getId()] = $possible;
						}
					}
				}
			}
			?><pre><b>$bellmanFordMatrix: </b><?php print_r($bellmanFordMatrix)?></pre><?php

			$resultMatrix[$s->getId()] = end($bellmanFordMatrix);
		}

		$result->setData($resultMatrix);
		$result->finalize();

		return $result;
	}

}