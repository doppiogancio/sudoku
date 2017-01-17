<?php

namespace core\Sudoku;

use core\Cell\Cell;
use core\Coordinate\Coordinate;

use core\Set\Row;
use core\Set\Set;
use core\Set\Region;
use core\Set\Column;

use core\Strategy\Strategy;

class Sudoku implements \SplObserver
{
	protected $grid;

    protected $numberPlaced = 0;

	/** @var Set[]  */
	protected $sets;

	public function __construct()
	{
		$this->sets = [];

		foreach (range(1,9) as $i) {
			$this->addSet(Row::get($i));
			$this->addSet(Column::get($i));
			$this->addSet(Region::get($i));
		}

		// row
		foreach (range(1,9) as $row) {
			// column
			foreach (range(1,9) as $column) {
				$cell = Cell::getInstance($row, $column);
				$regionId = Region::getIdByCoordinate($row, $column);

				Row::get($row)->addCell($cell);
				Column::get($column)->addCell($cell);
				Region::get($regionId)->addCell($cell);

				$cell->attach($this);
                $this->grid[$row][$column] = $cell;
			}
		}
	}

	/**
	 * @param Set $set
	 *
	 * @return $this
	 */
	public function addSet(Set $set)
	{
		$set->attach($this);

		$this->sets[] = $set;
		return $this;
	}

    /**
     * @param \SplSubject $subject
     */
    public function update(\SplSubject $subject)
    {
        if ($subject instanceof Cell) {
            if ($subject->hasValue()) {
                $this->numberPlaced++;

                if ($this->numberPlaced == 81) {

                }

                return ;
            }
        }

	    if ($subject instanceof Set) {
		    foreach ($this->sets as $key => $set) {
			    if ($set == $subject) {
				    unset($this->sets[$key]);
			    }
		    }
	    }
    }

	/**
	 * @return Set[]
	 */
	public function getSets()
	{
		return $this->sets;
	}

	/**
	 * @param $row
	 * @param $column
	 *
	 * @return Cell
	 */
	public function getCell($row, $column)
	{
		return Cell::getInstance($row, $column);
	}

	public function initFromString($string)
	{
		foreach (explode("\n", $string) as $rowNumber => $row) {
			$row = trim($row);

			for ($i=0; $i<strlen($row);$i++) {
				if ($row[$i] == '_') {
					continue;
				}

				$this->getCell($rowNumber + 1, $i + 1)
					->setValue($row[$i]);
			}
		}
	}

	public function setValueWithCoordinate($value, Coordinate $coordinate)
	{
		return $this->getCell($coordinate->getRow(), $coordinate->getColumn())
		     ->setValue($value);
	}

	public function setValues($values)
	{
		foreach ($values as $value) {
			$this->getCell($value[1], $value[2])
			     ->setValue($value[0]);
		}
	}

	public function getGrid()
	{
		return $this->grid;
	}
}