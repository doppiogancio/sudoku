<?php

namespace core\Set;

use core\Cell\Cell;

class Set implements \SplObserver, \SplSubject
{
	/** @var array[9] $cells  */
	protected $cells;

	/** @var  \SplObserver[] */
	protected $observers;

	public function __construct()
	{
		$this->cells = [];
		$this->observers = [];
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

	public function update( \SplSubject $subject )
	{
		if ( $subject instanceof Cell ) {
			$this->removeCell($subject);

			if (empty($this->getCells())) {
				return $this->notify();
			}

			$this->deleteCandidate($subject->getValue());
		}
	}

	public function addCell( Cell $cell )
	{
		$cell->attach($this);
		$this->cells[] = $cell;

		return $this;
	}

	/**
	 * @return Cell[]
	 */
	public function getCells()
	{
		return $this->cells;
	}

	public function removeCell( Cell $cell )
	{
	    print sprintf("Removing from region cell %s\n", $cell->__toString());

		foreach ($this->cells as $key => $c) {
			if ($c == $cell) {
				unset($this->cells[$key]);
			}
		}

		return $this;
	}

	public function deleteCandidate($candidate)
	{
		foreach ($this->getCells() as $cell) {
			$cell->deleteCandidate($candidate);
		}
	}

}