<?php

namespace Otus\ex21_ShortestPath;

use Otus\ex18_Vertex\Edge;
use Otus\ex18_Vertex\Graph;
use Otus\ex18_Vertex\Vertex;
use Otus\Result;

class DijkstraAlg
{
	protected Graph $graph;

	public function __construct(Graph $graph)
	{
		$this->graph = $graph;
	}

	public function getName(): string
	{
		return 'Edsger W. Dijkstra (1956)';
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

		$JohnsonAlg = (new JohnsonAlg($this->getGraph()));
		$result = $JohnsonAlg->apply();
		$JohnsonAlgValues = $result->getData();
		$newGraph = $JohnsonAlg->getGraph();

		$resultMatrix = $this->getGraph()->getPathMatrix();

		/* @var Vertex $examineVertex */
		foreach ($newGraph->getVertices() as $examineVertex)
		{
			$dijsktraMatrix = array_fill_keys(array_keys($resultMatrix[$examineVertex->getId()]), null);
			$dijsktraMatrix[$examineVertex->getId()] = 0;
			$notVisitedVertices = $dijsktraMatrix;
			/* @var Vertex $s */
			$s = $examineVertex;
			do
			{
				/** @var Edge $edge */
				unset($notVisitedVertices[$s->getId()]);
				foreach ($s->getOutgoingEdges() as $edge)
				{
//					if (array_key_exists($edge->getHead()->getId(), $notVisitedVertices))
					{
						$currentWeight = $dijsktraMatrix[$edge->getHead()->getId()];
						if ($dijsktraMatrix[$edge->getTail()->getId()] !== null)
						{
							$possibleWeight = $dijsktraMatrix[$edge->getTail()->getId()] + $edge->getWeight();
							if ($currentWeight === null || $currentWeight > $possibleWeight)
							{
								$dijsktraMatrix[$edge->getHead()->getId()] = $possibleWeight;
								$notVisitedVertices[$edge->getHead()->getId()] = $possibleWeight;
							}
						}
					}
				}
				asort($notVisitedVertices);
				unset($s);
				if ($sId = key($notVisitedVertices))
				{
					$s = $newGraph->getVertex($sId);
				}
			} while ($s instanceof Vertex);

			$resultMatrix[$examineVertex->getId()] = $dijsktraMatrix;
		}

		foreach ($resultMatrix as $tail => $dijsktraMatrix)
		{
			array_walk($dijsktraMatrix, function (&$val, $head, $JohnsonAlgValues) use ($tail) {
				$val = ($val ?? 0) - $JohnsonAlgValues[$tail] + $JohnsonAlgValues[$head];
			}, $JohnsonAlgValues);
			$resultMatrix[$tail] = $dijsktraMatrix;
		}

		$result->setData($resultMatrix);
		$result->finalize();

		return $result;
	}

}