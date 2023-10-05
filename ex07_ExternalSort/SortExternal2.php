<?php

namespace Otus\ex07_ExternalSort;

class SortExternal2 extends SortAlgs
{
	/**
	 * @var TestFile[] $files
	 */

	protected array $destinationFiles = [];
	protected int $countOfActiveFiles = 2;
	protected int $order = 1;
	protected int $pieceSize = 100;

	private function getDestinationFile(): TestFile
	{
		$fileNameSuffix = $this->order > 0 ? 'Asc' : 'Desc';
		if (count($this->destinationFiles) < $this->countOfActiveFiles)
		{
			$file = new TestFile(
				__DIR__ . '/testFiles/temp' .$fileNameSuffix . count($this->destinationFiles) . '.txt'
			);
			$file->clean();
		}
		else
		{
			$file = array_shift($this->destinationFiles);
		}
		$this->destinationFiles[] = $file;

		return $file;
	}

	public function run(TestFile $rawFile): TestFile
	{
		$sourceFiles = $this->divideIntoFiles($rawFile);
		do
		{
			$this->checkTime();
			$this->destinationFiles = [];
			$this->order *= -1;
			array_map(fn($f) => $f->rewind(), $sourceFiles);

			while(count($sourceFiles) > 0)
			{
				$sieve = new Sieve($sourceFiles);
				$destinationFile = $this->getDestinationFile();

				$min = $sieve->getNext();
				while($min !== null)
				{
					$this->checkTime();
					$destinationFile->add($min);
					$min = $sieve->getNext();
				}

				$sourceFiles = array_filter($sourceFiles, fn (TestFile $item) => $item->valid());
			}
			$this->checkTime();

			if (count($this->destinationFiles) > 1)
			{
				$sourceFiles = $this->destinationFiles;
				continue;
			}

			$file = reset($this->destinationFiles);

			break;
		} while (true);

		return $file;
	}

	private function divideIntoFiles(TestFile $rawFile): array
	{
		$rawFile->rewind();
		$this->order = -1;
		$this->destinationFiles = [];
		$sortAlg = new \Otus\ex06_SimpleSort\SortMerge();
		while ($piece = $rawFile->getData($this->pieceSize))
		{
			$file = $this->getDestinationFile();
			$piece = $sortAlg->setArray($piece)->sort()->get();
			$file->add(
				$piece
			);
		}

		return $this->destinationFiles;
	}
}
