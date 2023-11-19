<?php

namespace Otus\ex21_ShortestPath;

use Otus\ex18_Vertex\Graph;
use Otus\ex18_Vertex\Vertex;
use Otus\ex18_Vertex\Edge;
use Otus\Result;
use Otus\Alg;

class FloydWarshallAlg extends Alg
{
	protected Graph $graph;

	public function __construct(Graph $graph)
	{
		$this->graph = $graph;
	}

	public function getName(): string
	{
		return 'Floyd&Warshall (1962)';
	}

	public function apply(): Result
	{
		$resultMatrix = $this->graph->getPathMatrix();
		$nextTo = [];
		$result = new Result();
		/* @var Vertex $k */
		foreach ($this->graph->getVertices() as $k)
		{
			/* @var Vertex $start */
			foreach ($this->graph->getVertices() as $start)
			{
				$nextTo[$start->getId()] = [];
				/* @var Vertex $end */
				foreach ($this->graph->getVertices() as $end)
				{
					$current = $resultMatrix[$start->getId()][$end->getId()];
					$zigZag = $resultMatrix[$start->getId()][$k->getId()]!==null && $resultMatrix[$k->getId()][$end->getId()]!==null
						? ($resultMatrix[$start->getId()][$k->getId()] + $resultMatrix[$k->getId()][$end->getId()])
						: null
					;
					if ($zigZag !== null && ($current === null || $current > $zigZag))
					{
						$current = $zigZag;
						$nextTo[$start->getId()][$end->getId()] = $k->getId();
					}

					$resultMatrix[$start->getId()][$end->getId()] = $current;
				}
			}
		}

		$result->setData($resultMatrix);
		$result->finalize();
		return $result;
	}
}
