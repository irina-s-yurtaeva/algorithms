<?php

namespace Otus\ex10_AVL;

use Otus\Timer;

abstract class Tree
{
	public const CODE = 'Abstract';
	protected const TIMEOUT_FOR_BUILDING = 120;
	protected const TIMEOUT_FOR_SEARCHING = 20;
	protected const TIMEOUT_FOR_REMOVING = 20;

	protected array $array = [];
	protected int $length = 0;
	protected Timer $timer;
	protected Node $root;

	public function makeBinaryTreeFromArray(array $array, int $timeout = 20): \Otus\Result
	{
		$this->array = $array;
		$this->length = count($array);

		$result = new \Otus\Result();
		$this->resetTimer(new Timer(
			self::TIMEOUT_FOR_BUILDING,
			$result->getTimeStart()
		));
		try
		{
			$result->setData(['root' => $this->makeABinaryTree()]);
			$result->finalize();
		}
		catch (\Otus\TimeoutException $e)
		{

		}
		return $result;
	}

	public function searchElements(array $nodeValues): ResultAffectedElements
	{
		$result = new ResultAffectedElements($nodeValues);
		$this->resetTimer(new Timer(
			self::TIMEOUT_FOR_SEARCHING,
			$result->getTimeStart()
		));
		try
		{
			$dfs = new \Otus\ex10_AVL\VisitorDFSearcher();
			foreach ($nodeValues as $value)
			{
				$foundNode = $dfs->apply($this->root, $value);
				if ($foundNode !== null)
				{
					$result->addAffectedElement($value);
				}
			}
			$result->finalize();


			$result->finalize();
		}
		catch (\Otus\TimeoutException $e)
		{

		}
		return $result;
	}

	public function removeElements(array $nodeValues): ResultAffectedElements
	{
		$result = new ResultAffectedElements($nodeValues);
		$this->resetTimer(new Timer(
			self::TIMEOUT_FOR_SEARCHING,
			$result->getTimeStart()
		));
		try
		{
			$dfs = new \Otus\ex10_AVL\VisitorDFSearcher();
			foreach ($nodeValues as $value)
			{
				$foundNode = $dfs->apply($this->root, $value);
				if ($foundNode !== null)
				{
					$foundNode->remove();
					$result->addAffectedElement($value);
				}
			}
			$result->finalize();


			$result->finalize();
		}
		catch (\Otus\TimeoutException $e)
		{

		}
		return $result;
	}

	protected function resetTimer(\Otus\Timer $timer): void
	{
		$this->timer = $timer;
	}

	protected function checkTime(): bool
	{
		return $this->timer->check();
	}


	abstract protected function makeABinaryTree(): ?Node;

	abstract public function insert(int $value): Node;
}
