<?php

namespace core\Cell;

use core\Coordinate\Coordinate;
use core\Exception\LastCandidateException;
use core\Exception\NotEmptyException;
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
		if ($this->hasValue()) {
		    throw new NotEmptyException();
		}

		if (!is_numeric($value) || ($value < 1) || ($value > 9)) {
            throw new WrongValueException('WrongValueException: '.$value);
		}

		if (!in_array($value, $this->getCandidates())) {
		    throw new WrongValueException('Illegal value');
		}

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
			throw new LastCandidateException("Trying to delete last cell candidate");
		}

		if ($this->hasValue()) {
			throw new NotEmptyException();
		}

		if (!$this->hasCandidate($candidate)) {
			throw new WrongValueException();
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