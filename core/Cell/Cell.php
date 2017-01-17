<?php

namespace core\Cell;

use core\Coordinate\Coordinate;
use core\Exception\LastCandidateException;
use core\Exception\WrongValueException;
use core\Log\Log;

class Cell implements \SplSubject
{
	/**
	 * @var Cell[9][9]
	 */
	static $cell;

	/**
	 * @var int
	 */
	protected $value;

	/**
	 * @var int[]
	 */
	protected $candidates;

	/**
	 * @var Coordinate
	 */
    protected $coordinate;

	/**
	 * @var \SplObserver[]
	 */
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
	 * @return $this
	 */
	public function notify()
	{
		foreach($this->observers as $observer) {
			/** @var \SplObserver $observer */
			$observer->update($this);
		}

		return $this;
	}

	/**
	 * @return Coordinate
	 */
	public function getCoordinate()
	{
		return $this->coordinate;
	}

	/**
	 * @return bool
	 */
	public function hasValue()
	{
		return $this->value != SUDOKU_DEFAULT_CELL_VALUE;
	}

	/**
	 * @param $value
	 *
	 * @return $this|Cell
	 * @throws WrongValueException
	 */
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

		Log::addInfo('Set value', $this->__toString());

		return $this->notify();
	}

	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @return array
	 */
	public function getCandidates()
	{
		return $this->candidates;
	}

	/**
	 * @return int
	 */
	public function countCandidates()
	{
		return count($this->getCandidates());
	}

	/**
	 * @return bool
	 */
	public function hasCandidates()
	{
		return $this->countCandidates() > 0;
	}

	/**
	 * @param $candidate
	 *
	 * @return bool
	 */
	public function hasCandidate($candidate)
	{
		return in_array($candidate, $this->getCandidates());
	}

	/**
	 * @param $candidate
	 *
	 * @return $this
	 * @throws LastCandidateException
	 * @throws WrongValueException
	 */
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
			Log::addSuccess('Ultimo candidato', sprintf("Ultimo candidato per %s", $this->__toString()));
		    $value = current($this->getCandidates());
			$this->setValue($value);
        }

		return $this;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return sprintf("Cell at (%d,%d) = %s", $this->getCoordinate()->getRow(), $this->getCoordinate()->getColumn(), $this->getValue());
	}
}