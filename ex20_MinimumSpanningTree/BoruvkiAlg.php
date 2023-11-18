<?php

namespace Otus\ex20_MinimumSpanningTree;

use Otus\ex18_Vertex\Graph;
use Otus\ex18_Vertex\Vertex;
use Otus\ex18_Vertex\Edge;
use Otus\Result;

class BoruvkiAlg
{
	protected Graph $graph;

	public function __construct(Graph $graph)
	{
		$this->graph = $graph;
	}

	public function getName(): string
	{
		return 'Otakar Boruvki (1926)';
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
		$components = [];
		foreach ($this->graph->getVertices() as $vertex)
		{
			$components[$vertex->getId()] = (new Graph())->addVertex($vertex);
		}

		while (count($components) > 1)
		{
			foreach ($components as $newGraph)
			{
				$edges = [];
				foreach ($newGraph->getVertices() as $vertex)
				{
					$probedVertex = $this->graph->getVertex($vertex->getId());
					$edges = [...$edges, ...$probedVertex->getOutgoingEdges(), ...$probedVertex->getIncomingEdges()];
				}
				uasort($edges, fn(Edge $e1, Edge $e2) => $e1->getWeight() > $e2->getWeight());
				/** @var Edge $edge */
				foreach ($edges as $edge)
				{
					if (in_array($edge->getHead(), $newGraph->getVertices()) && in_array($edge->getTail(), $newGraph->getVertices()))
					{
						continue;
					}
					break;
				}

				if ($edge)
				{
					$newGraph->addEdge($edge)->addVertex($edge->getTail())->addVertex($edge->getHead());
				}
			}

			$nextComponents = [];

			/** @var Graph $nextComponent */
			while ($nextComponent = array_shift($components))
			{
				/** @var Graph $newGraph */
				foreach ($components as $newGraph)
				{
					foreach ($nextComponent->getVertices() as $v)
					{
						if ($newGraph->hasVertex($v))
						{
							foreach ($newGraph->getVertices() as $v1)
								$nextComponent->addVertex($v1);
							foreach ($newGraph->getEdges() as $e)
								$nextComponent->addEdge($e);
							$newGraph->consumed = true;
							break;
						}
					}
				}
				$nextComponents[] = $nextComponent;
				$components = array_filter($components, fn($newGraph) => !isset($newGraph->consumed));
			}
			$components = $nextComponents;
		}
		$resultGraph = reset($components);
		$res = array_reduce($resultGraph->getEdges(), fn($edge, $carry) => $carry + $edge->getWeight());
		echo '$res: ', $res."\n";

		$result->setData([$res]);
		$result->finalize();
		return $result;
	}
}
