<?php

namespace Otus\ex21_ShortestPath;

use Otus\ex18_Vertex\Edge;
use Otus\ex18_Vertex\Graph;
use Otus\ex18_Vertex\Vertex;
use Otus\Result;

class JohnsonAlg
{
	protected Graph $graph;

	public function __construct(Graph $graph)
	{
		$this->graph = clone $graph;
	}

	public function getName(): string
	{
		return 'Johnson D. B. (1977)';
	}

	/**
	 * @return Graph
	 */
	public function getGraph(): Graph
	{
		return $this->graph;
	}

	public function apply(): Result
	{
		$result = new Result();

		$positivatingVertex = new Vertex('p');
		$newGraph = clone $this->getGraph();
		/* @var Vertex $v */
		$newGraph->addVertex($positivatingVertex);
		foreach ($newGraph->getVertices() as $v)
		{
			if ($v === $positivatingVertex)
			{
				continue;
			}
			$newGraph->addEdge(new Edge($positivatingVertex, $v, 0));
		}

		$h = (new BellmanFordAlg($newGraph))->apply()->getData()['p'];
		/**
		 * @var Edge $edge
		 * @var Vertex $tail
		 * @var Vertex $head
		 */
		foreach ($this->graph->getEdges() as $edge)
		{
			$weight = $edge->getWeight();

			$edge->setWeight(
				$weight
				+ $h[$edge->getTail()->getId()]
				- $h[$edge->getHead()->getId()]
			);
		}

		$result->setData($h);
		$result->finalize();

		return $result;
	}
}
