<?php

namespace core\Sudoku;

use core\Cell\Cell;
use core\Coordinate\Coordinate;
use core\Queue\Queue;

use core\Strategy\Strategy;
use core\Strategy\StrategyRowFiller;
use core\Strategy\StrategyColumnFiller;
use core\Strategy\StrategyRegionFiller;
use SplObserver;
use SplSubject;

class Sudoku implements SplObserver
{
	protected $grid;
	protected $q;

    protected $strategies;
    protected $numberPlaced = 0;

	public function __construct()
	{
		for ($i=1;$i<=9;$i++) {
			for ($j=1;$j<=9;$j++) {
				$cell = new Cell(new Coordinate($i, $j));
                $this->grid[$i][$j] = $cell;
                $cell->attach($this);
			}
		}

		$this->strategies = [
			new StrategyRowFiller($this),
			new StrategyColumnFiller($this),
			new StrategyRegionFiller($this)
		];
	}

    /**
     * @param SplSubject $subject
     */
    public function update(SplSubject $subject)
    {
        if ($subject instanceof Cell) {
            if ($subject->hasValue()) {
                $this->numberPlaced++;

                echo sprintf("numberPlaced #%d\n", $this->numberPlaced);

                if ($this->numberPlaced == 81) {
                    throw new \Exception('End of the game');
                }

                return ;
            }

            $candidates = $subject->getCandidates();

            if (empty($candidates)) {
                $cell = $this->q->shift();
                return;
            }

            $newValue = array_shift($candidates);

            $this->setValue($newValue, $subject->getCoordinate()->getRow(), $subject->getCoordinate()->getColumn());
        }
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

		if (!$cell->hasCandidate($value)) {
			return $this;
		}

		$cell->deleteCandidate($value);

		return $this;
	}

	protected function _deleteCandidateFromRow($value, $row)
	{
		for ($i = 1; $i <= 9; $i++) {
			$this->deleteCandidateFromCell($value, $row, $i);
		}
	}

	protected function _deleteCandidateFromColumn($value, $column)
	{
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
		$cell = $this->getCell($row, $column);

		if ($cell->hasValue()) {
		    return ;
        }

		$cell->setValue($value);

		// TODO: Elimina tale valore da tutti i candidati della riga, colonna, e regione

		$this->_deleteCandidateFromRow($value, $row);
		$this->_deleteCandidateFromColumn($value, $column);
		$this->_deleteCandidateFromRegion($value, $row, $column);

		return $this;
	}

	public function setValues($values)
	{
		foreach ($values as $value) {
			$this->setValue($value[0], $value[1], $value[2]);
		}
	}

	public function getGrid()
	{
		return $this->grid;
	}
}