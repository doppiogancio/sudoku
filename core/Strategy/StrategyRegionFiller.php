<?php
/**
 * Created by PhpStorm.
 * User: fabriziogargiulo
 * Date: 08/01/17
 * Time: 17:48
 */

namespace core\Strategy;

use core\Cell\Cell;


class StrategyRegionFiller extends Strategy
{
	protected function getRegion($number)
	{
		$set = [];

		$starts = [
			[],

			[ 'row' => 1, 'column' => 1 ],
			[ 'row' => 1, 'column' => 4 ],
			[ 'row' => 1, 'column' => 7 ],


			[ 'row' => 4, 'column' => 1 ],
			[ 'row' => 4, 'column' => 4 ],
			[ 'row' => 4, 'column' => 7 ],


			[ 'row' => 7, 'column' => 1 ],
			[ 'row' => 7, 'column' => 4 ],
			[ 'row' => 7, 'column' => 7 ],
		];


		$maxRow = $starts[$number]['row'] + 3;
		$maxColumn = $starts[$number]['column'] + 3;

		for ($row = $starts[$number]['row']; $row < $maxRow; $row++) {
			for ($column = $starts[$number]['column']; $column < $maxColumn; $column++) {
				$set[] = $this->sudoku->getCell($row, $column);
			}
		}

		return $set;
	}

	public function execute()
	{
		foreach (range(1,9) as $number) {
			$this->executeWithNumber($number);
		}
	}

	public function executeWithNumber($number)
	{
		foreach (range(1,9) as $regionNumber) {
			$cellCandidates = [];

			$set = $this->getRegion($regionNumber);

			/** @var Cell $cell */
			foreach ($set as $cell) {
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
				echo sprintf("__Region %d can place %s %s\n", $regionNumber, $number, $cellCandidates[0]);
				/** @var Cell $cell */
				$cell = $cellCandidates[0];
				$this->sudoku->setValueWithCoordinate($number, $cell->getCoordinate());
			}
		}

	}
}