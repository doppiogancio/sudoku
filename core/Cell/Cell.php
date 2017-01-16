<?php

namespace core\Cell;

use core\Coordinate\Coordinate;
use core\Exception\LastCandidateException;
use core\Exception\NotEmptyException;
use core\Exception\WrongValueException;

class Cell implements \SplSubject
{
	/** @var  Cell[9][9] */
	static $cell;
	protected $value;
	protected $candidates;

    protected $coordinate;

	/** @var  \SplObserver[] */
	protected $observers;

	public function __construct(Coordinate $coordinate)
	{
		$this->value = SUDOKU_DEFAULT_CELL_VALUE;
		$this->candidates = range(1,9);

		$this->coordinate = $coordinate;
		$this->observers = [];
	}

	/**
	 * @param $row
	 * @param $column
	 *
	 * @return Cell
	 */
	static public function getInstance($row, $column)
	{
	    if (!isset(self::$cell[$row])) {
            self::$cell[$row] = [];
        }

        if (!isset(self::$cell[$row][$column])) {
            self::$cell[$row][$column] = null;
        }

		if (empty(self::$cell[$row][$column])) {
			self::$cell[$row][$column] = new Cell(new Coordinate($row, $column));
		}

		return self::$cell[$row][$column];
	}

	/**
	 * @param \SplObserver $observer
	 *
	 * @return mixed
	 */
	public function attach( \SplObserver $observer )
	{
		$this->observers[] = $observer;
		return $this;
	}

	/**
	 * @param \SplObserver $observer
	 *
	 * @return mixed
	 */
	public function detach( \SplObserver $observer )
	{
		foreach ($this->observers as $key => $o) {
			if ($o == $observer) {
				unset($this->observers[$key]);
			}
		}

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function notify()
	{
		foreach($this->observers as $observer) {
			/** @var \SplObserver $observer */
			$observer->update($this);
		}

		return $this;
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
		    return $this;
		}

		if (!is_numeric($value) || ($value < 1) || ($value > 9)) {
            throw new WrongValueException('WrongValueException: '.$value);
		}

		if (!in_array($value, $this->getCandidates())) {
		    throw new WrongValueException(sprintf("Trying to setValue(%d) with (%s)", $value, implode(",", $this->getCandidates())));
		}

		$this->value = $value;
		$this->candidates = [];

		return $this->notify();
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
			return $this;
		}

		if (!$this->hasCandidate($candidate)) {
			return $this;
		}

		$key = array_search($candidate, $this->candidates);

		if($key !== false) {
			unset($this->candidates[$key]);
		}

		if ($this->countCandidates() === 1) {
		    $value = current($this->getCandidates());
			$this->setValue($value);
        }
	}

	public function __toString()
	{
		return sprintf("Cell at (%d,%d) = %s", $this->getCoordinate()->getRow(), $this->getCoordinate()->getColumn(), $this->getValue());
	}
}