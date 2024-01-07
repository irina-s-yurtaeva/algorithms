<?php

namespace Otus\ex09_BillionNumbersSort;

use Otus\ex07_ExternalSort\TestFile;
use Otus\Result;

class BucketSortAlg extends SortAlg
{
	protected int $statMaxElementsInAList = 0;
	protected int $statsBucketsCount = 0;

	public function getName(): string
	{
		return 'Bucket sort';
	}

	public function sort(): void
	{
		$this->file->rewind();
		$maxNumber = 0;
		while ([$number] = $this->file->getData(1))
		{
			$maxNumber = $maxNumber > $number ? $maxNumber : $number;
			$this->iterate();
			$this->timer->check();
		}
		$bucketsCount = $maxNumber / 10;
		$this->statsBucketsCount = $bucketsCount;

		$maxNumber++;
		$buckets = array_fill(0, $bucketsCount, null);
		$this->file->rewind();
		while ([$number] = $this->file->getData(1))
		{
			$bucketNumber = (int) ($number * $bucketsCount / $maxNumber);
			$buckets[$bucketNumber] = new ListSortElement($number, ($buckets[$bucketNumber] ?? null));

			$list = $buckets[$bucketNumber];
			while ($list->getNext() !== null)
			{
				if ($list->getValue() < $list->getNext()->getValue())
				{
					break;
				}
				$this->iterate();
				$buff = $list->getValue();
				$list->setValue($list->getNext()->getValue());
				$list->getNext()->setValue($buff);
				$list = $list->getNext();
				$this->timer->check();
			}
		}
		$checkResult = 0;
		$this->statsFinalElementsCount = 0;
		$this->statMaxElementsInAList = 0;
		foreach ($buckets as $list)
		{
			if (!($list instanceof ListSortElement))
			{
				continue;
			}
			else
			{
				/** @var ListSortElement $bucketList */
				$listInABucket = 0;
				do
				{
					$this->statsFinalElementsCount++;
					$this->iterate();
					if ($checkResult > $list->getValue())
					{
						throw new \ErrorException('Bad sort');
					}
					$checkResult = $list->getValue();
					$listInABucket++;
				} while ($list = $list->getNext());
				$this->statMaxElementsInAList = max($this->statMaxElementsInAList, $listInABucket);
			}
		}
	}

	public function getStats(): string
	{
		$res = parent::getStats() . ' Max elements in a List = ' . $this->statMaxElementsInAList
			. ' BucketsCount: ' . $this->statsBucketsCount
			. ' FinalElementsCount: ' . $this->statsFinalElementsCount
		;

		return $res;
	}
}
