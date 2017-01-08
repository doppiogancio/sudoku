<?php
/**
 * Created by PhpStorm.
 * User: fabriziogargiulo
 * Date: 08/01/17
 * Time: 17:48
 */

namespace core\Strategy;

use core\Cell\Cell;


class StrategyRowFiller extends Strategy
{
	public function execute()
	{
		foreach (range(1,9) as $number) {
			$this->executeWithNumber($number);
		}
	}

	public function executeWithNumber($number)
	{
		foreach ($this->sudoku->getGrid() as $row => $rows) {
			$cellCandidates = [];

			//echo sprintf("Checking row %d\n", $row);

			foreach ($rows as $column => $cell) {
				//echo sprintf("Checking column %d\n", $column);

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
				//echo sprintf("Row %d can place %s %s\n", $row, $number, $cellCandidates[0]);
				/** @var Cell $cell */
				$cell = $cellCandidates[0];
				$this->sudoku->setValueWithCoordinate($number, $cell->getCoordinate());
			}

		}
	}
}