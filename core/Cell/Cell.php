<?php

namespace core\Cell;

use core\Coordinate\Coordinate;
use core\Exception\WrongValueException;

class Cell
{
	protected $value;
	protected $candidates;

	protected $coordinate;

	protected $row;
	protected $column;
	protected $region;

	public function __construct(Coordinate $coordinate)
	{
		$this->value = SUDOKU_DEFAULT_CELL_VALUE;
		$this->candidates = range(1,9);

		$this->coordinate = $coordinate;

		$this->row = null;
		$this->column = null;
		$this->region = null;
	}

	public function getCoordinate()
	{
		return $this->coordinate;
	}

	public function hasValue()
	{
		return $this->value != SUDOKU_DEFAULT_CELL_VALUE;
	}

	public function setValue($value)
	{
		$coordinate = $this->coordinate;

		if ($this->hasValue()) {
		    throw new NotEmptyException();
		    exit;

			echo sprintf(
				"ERROR: Cell (%d,%d) has already a value",
				$coordinate->getRow(),
				$coordinate->getColumn()
			);

			return false;
		}

		if (!is_numeric($value) || ($value < 1) || ($value > 9)) {
            throw new WrongValueException('vediamo se se la prende!!!');

			echo sprintf(
				"ERROR: wrong value for setValue(%d) at (%d,%d)\n",
				$value,
				$coordinate->getRow(),
				$coordinate->getColumn()
			);

			return;
		}

		if (!in_array($value, $this->getCandidates())) {
		    throw new WrongValueException('Questo valore non e buono!!!');

            exit;

			echo sprintf(
				"ERROR: value is in not a candidate (%s) for setValue(%d) at (%d,%d)\n",
				implode(",", $this->getCandidates()),
				$value,
				$coordinate->getRow(),
				$coordinate->getColumn()
			);

			return;
		}

		// Override with correct values
		echo sprintf("setValue %d at (%d,%d)\n", $value, $coordinate->getRow(), $coordinate->getColumn());

		$this->value = $value;
		$this->candidates = [];
	}

	public function getValue()
	{
		return $this->value;
	}

	public function getCandidates()
	{
		return $this->candidates;
	}

	public function countCandidates()
	{
		return count($this->getCandidates());
	}

	public function hasCandidates()
	{
		return $this->countCandidates() > 0;
	}

	public function hasCandidate($candidate)
	{
		return in_array($candidate, $this->getCandidates());
	}

	public function deleteCandidate($candidate)
	{
		if ($this->countCandidates() === 1) {
			return ;
			print sprintf(
				"ERROR: trying to delete a candidate(%d) from (%s) for cell (%d,%d) with a single candidate. Its value %s\n",
				$candidate,
				implode(",", $this->getCandidates()),
				$this->getCoordinate()->getRow(),
				$this->getCoordinate()->getColumn(),
				$this->getValue()
			);

		}

		if ($this->hasValue()) {
			return ;

			print sprintf(
				"ERROR: trying to delete a candidate for cell (%d,%d). Its value %d\n",
				$this->getCoordinate()->getRow(),
				$this->getCoordinate()->getColumn(),
				$this->getValue()
			);

			return ;
		}

		if (!$this->hasCandidates()) {
			return ;
			throw new Exception(
				sprintf(
					"no candidates for cell (%d,%d)\n",
					$this->getCoordinate()->getRow(),
					$this->getCoordinate()->getColumn()
				)
			);
		}

		$key = array_search($candidate, $this->candidates);

		if($key !== false) {
			unset($this->candidates[$key]);
		}
	}

	public function __toString()
	{
		return sprintf("Cell at (%d,%d) = %s", $this->getCoordinate()->getRow(), $this->getCoordinate()->getColumn(), $this->getValue());
	}
}