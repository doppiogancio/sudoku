<?php

namespace core\Strategy;

use core\Cell\Cell;

use core\Set\Set;
use core\Set\Row;
use core\Set\Region;
use core\Set\Column;

class StrategyCandidatesRow extends Strategy
{
	/**
	 * @param core\Set\Row
	 * @param $candidate
	 * @param array $excludeColumns
	 *
	 * @return $this
	 */
	protected function deleteCandidateFromRowWithExclude(Row $row, $candidate, array $excludeColumns)
	{
		foreach ($row->getCells() as $cell) {
			if (!in_array($cell->getCoordinate()->getColumn(), $excludeColumns)) {
				$cell->deleteCandidate($candidate);
			}
		}

		return $this;
	}

	protected function deleteCandidateFromColumnWithExclude(Column $column, $candidate, array $excludeRows)
	{
		foreach ($column->getCells() as $cell) {
			if (!in_array($cell->getCoordinate()->getRow(), $excludeRows)) {
				$cell->deleteCandidate($candidate);
			}
		}

		return $this;
	}

	/**
	 * @param Set $set
	 * @param $number
	 */
	protected function executeStrategy(Set $set, $number)
	{
		$rows = [];
		$columns = [];

		foreach ($set->getCells() as $cell) {
			/** @var Cell $cell */
			if ($cell->hasValue() && $cell->getValue() == $number) {
				break;
			}

			if ($cell->hasValue()) {
				continue;
			}

			if ($cell->hasCandidate($number)) {
				$row = $cell->getCoordinate()->getRow();
				$column = $cell->getCoordinate()->getColumn();

				if (empty($rows[$row])) {
					$rows[$row] = 0;
				}

				if (empty($columns[$column])) {
					$columns[$column] = 0;
				}

				$rows[$row]++;
				$columns[$column]++;
			}
		}

		if (count($rows) === 1 && count($columns) === 1) {
			//print sprintf("Candidato %d in posizione esatta (%d, %d)<br>", $number, key($rows), key($columns));
			return ;
		}

		if (empty($rows) || empty($columns)) {
			return ;
		}

		if (count($rows) === 1) {
			$row = key($rows);

			if (Row::get($row)->countCellsWithCandidate($number) == $rows[$row]) {
				return ;
			}

			print sprintf("Eliminare tutti i <b>%d</b> dalla riga %d eccetto regione %d: (%d>%d).\n<br>",
				$number, $row, $set->getId(),
				Row::get($row)->countCellsWithCandidate($number),
				$rows[$row]
			);

			$this->deleteCandidateFromRowWithExclude(Row::get($row), $number, array_keys($columns));
		}

		if (count($columns) === 1) {
			$column = key($columns);

			if (Column::get($column)->countCellsWithCandidate($number) == $columns[$column]) {
				return ;
			}

			print sprintf("Eliminare tutti i <b>%d</b> dalla colonna %d eccetto regione %d.\n<br>", $number, $column, $set->getId());

			$this->deleteCandidateFromColumnWithExclude(Column::get($column), $number, array_keys($rows));
		}
	}

	/**
	 * @param Set[] $sets
	 */
	public function execute(array $sets)
	{
		$newSets = [];

		foreach ($sets as $set) {
			if ($set instanceof Region) {
				$newSets[] = $set;
			}
		}

		return parent::execute($newSets);
	}
}

