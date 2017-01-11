<?php

namespace core\Sudoku;

use core\Cell\Cell;
use core\Coordinate\Coordinate;
use core\Queue\Queue;

use core\Strategy\Strategy;
use core\Strategy\StrategyRowFiller;
use core\Strategy\StrategyColumnFiller;
use core\Strategy\StrategyRegionFiller;

class Sudoku {
	protected $grid;
	protected $q;

	protected $strategies;

	public function __construct()
	{
		$this->q = new Queue();

		for ($i=1;$i<=9;$i++) {
			for ($j=1;$j<=9;$j++) {
				$this->grid[$i][$j] = new Cell(new Coordinate($i, $j));
			}
		}

		$this->strategies = [
			new StrategyRowFiller($this),
			new StrategyColumnFiller($this),
			new StrategyRegionFiller($this)
		];
	}

	public function applyStrategies()
	{
		/** @var Strategy $strategy */
		foreach ($this->strategies as $strategy) {
			$strategy->execute();
		}
	}

	/**
	 * @param $row
	 * @param $column
	 *
	 * @return Cell
	 */
	public function getCell($row, $column)
	{
		return $this->grid[$row][$column];
	}

	public function initFromString($string)
	{
		foreach (explode("\n", $string) as $rowNumber => $row) {
			$row = trim($row);

			for ($i=0; $i<strlen($row);$i++) {
				if ($row[$i] == '_') {
					continue;
				}

				$this->setValue($row[$i], $rowNumber + 1, $i + 1);
			}
		}
	}

	public function processQueue()
	{
		/** @var Cell $cell */
		$cell = $this->q->shift();

		while (!empty($cell)) {
			$candidates = $cell->getCandidates();

			if (empty($candidates)) {
				$cell = $this->q->shift();
				continue;
			}

			$newValue = array_shift($candidates);

			$this->setValue($newValue, $cell->getCoordinate()->getRow(), $cell->getCoordinate()->getColumn());

			$cell = $this->q->shift();
		}
	}

	public function getCellCandidates($row, $column)
	{
		/** @var Cell $cell */
		$cell = $this->grid[$row][$column];
		return $cell->getCandidates();
	}

	public function deleteCandidateFromCell($value, $row, $column)
	{
		/** @var Cell $cell */
		$cell = $this->grid[$row][$column];

		//echo sprintf("deleteCandidateFromCell %d at (%d,%d)\n", $value, $row, $column);

		$cell->deleteCandidate($value);

		if ($cell->countCandidates() == 1) {
			//echo sprintf("adding to queue value %d for cell at (%d,%d)\n", $newValue, $row, $column);
			$this->q->push($cell);
		}

		return $this;
	}

	protected function _deleteCandidateFromRow($value, $row)
	{
		//echo sprintf("_deleteCandidateFromRow %d from row %d\n", $value, $row);

		for ($i = 1; $i <= 9; $i++) {
			$this->deleteCandidateFromCell($value, $row, $i);
		}
	}

	protected function _deleteCandidateFromColumn($value, $column)
	{
		//echo sprintf("_deleteCandidateFromColumn %d from row %d\n", $value, $column);

		for ($i = 1; $i <= 9; $i++) {
			$this->deleteCandidateFromCell($value, $i, $column);
		}
	}

	protected function _getRegionOriginByCell($row, $column)
	{
		$origin = [
			'row' => 4,
			'column' => 4
		];

		if ($row < 4) {
			$origin['row'] = 1;
		}

		if ($row > 6) {
			$origin['row'] = 7;
		}

		if ($column < 4) {
			$origin['column'] = 1;
		}

		if ($column > 6) {
			$origin['column'] = 7;
		}

		return $origin;
	}

	protected function _deleteCandidateFromRegion($value, $row, $column)
	{
		$origin = $this->_getRegionOriginByCell($row, $column);

		//echo sprintf("_deleteCandidateFromRegion %d from region(%d,%d)\n", $value, $origin['row'], $origin['column']);

		for ($row = $origin['row']; $row <= ($origin['row'] + 2); $row++) {
			for ($column = $origin['column']; $column <= ($origin['column'] + 2); $column++) {
				$this->deleteCandidateFromCell($value, $row, $column);
			}
		}
	}

	public function setValueWithCoordinate($value, Coordinate $coordinate)
	{
		return $this->setValue($value, $coordinate->getRow(), $coordinate->getColumn());
	}

	public function setValue($value, $row, $column)
	{
		/** @var Cell $cell */
		$cell = $this->grid[$row][$column];

		$cell->setValue($value);

		// TODO: Elimina tale valore da tutti i candidati della riga, colonna, e regione

		$this->_deleteCandidateFromRow($value, $row);
		$this->_deleteCandidateFromColumn($value, $column);
		$this->_deleteCandidateFromRegion($value, $row, $column);

		if (!$this->q->isEmpty()) {
			//echo sprintf("La Q non e' vuota!!!\n");
			$this->processQueue();
		}

		return $this;
	}

	public function setValues($values) {
		foreach ($values as $value) {
			$this->setValue($value[0], $value[1], $value[2]);
		}
	}

	public function getGrid()
	{
		return $this->grid;
	}
}