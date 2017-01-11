<?php

namespace core\Strategy;

use core\Cell\Cell;


class StrategyColumnFiller extends Strategy
{
	public function execute()
	{
		foreach (range(1,9) as $number) {
			$this->executeWithNumber($number);
		}
	}

	public function executeWithNumber($number)
	{
		$columns = range(1,9);
		$rows = range(1,9);

		foreach ($columns as $column) {
			$cellCandidates = [];

			foreach ($rows as $row) {
				$cell = $this->sudoku->getCell($row, $column);

				/** @var Cell $cell */
				if ($cell->hasValue() && $cell->getValue() == $number) {
					//echo sprintf("Row %d has already number %d\n", $row, $number);
					break;
				}

				if ($cell->hasValue()) {
					//echo sprintf("Column %d has already a value %d\n", $column, $cell->getValue());
					continue;
				}

				if ($cell->hasCandidate($number)) {
					$cellCandidates[] = $cell;
				}
			}

			if (count($cellCandidates) === 1) {
				//echo sprintf("Column %d can place %s %s\n", $column, $number, $cellCandidates[0]);
				/** @var Cell $cell */
				$cell = $cellCandidates[0];
				$this->sudoku->setValueWithCoordinate($number, $cell->getCoordinate());
			}
		}
	}
}