<?php

namespace Otus\ex20_MinimumSpanningTree;

use Otus\ex18_Vertex\Graph;
use Otus\ex18_Vertex\Vertex;
use Otus\ex18_Vertex\Edge;
use Otus\Result;
use Otus\Alg;

class PrimaAlg extends Alg
{
	protected Graph $graph;

	public function __construct(Graph $graph)
	{
		$this->graph = $graph;
	}

	public function getName(): string
	{
		return 'Robert Prima (1957)';
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
		$graphVertices = $this->graph->getVertices();
		$countGraphVertices = count($graphVertices);
		$vertex = array_slice($graphVertices, rand(0, $countGraphVertices-1), 1);
		$newGraph = new Graph();
		$v = array_shift($vertex);
		$newGraph->addVertex($v);
		while (count($newGraph->getVertices()) != $countGraphVertices)
		{
			/**
			 * @var Vertex $vertex
			 */
			$minEdge = null;
			foreach ($newGraph->getVertices() as $vertex)
			{
				$probedVertex = $this->graph->getVertex($vertex->getId());
				/** @var Edge $edge */
				foreach ([...$probedVertex->getOutgoingEdges(), ...$probedVertex->getIncomingEdges()] as $edge)
				{
					if (in_array($edge->getHead(), $newGraph->getVertices()) && in_array($edge->getTail(), $newGraph->getVertices()))
					{
						continue;
					}
					$minEdge = $minEdge === null || $minEdge->getWeight() > $edge->getWeight() ? $edge : $minEdge;
				}
			}
			$newGraph->addEdge($minEdge)->addVertex($minEdge->getHead())->addVertex($minEdge->getTail());
		}
		$result->setData([array_reduce($newGraph->getEdges(), fn($sum, $edge) => $sum + $edge->getWeight(), 0)]);
		$result->finalize();

		return $result;
	}

}