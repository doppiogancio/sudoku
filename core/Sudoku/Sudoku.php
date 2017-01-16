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

	/**
	 * @var Row[]
	 */
	protected $rows;

	/**
	 * @var Column[]
	 */
	protected $columns;

	/**
	 * @var Region[]
	 */
	protected $regions;

	public function __construct()
	{

		$this->rows = [];
		$this->columns = [];
		$this->regions = [];

		foreach (range(1,9) as $i) {
			$this->rows[$i] = (new Row())->attach($this);
			$this->columns[$i] = (new Column())->attach($this);
			$this->regions[$i] = (new Region())->attach($this);
		}

		// row
		foreach (range(1,9) as $row) {
			// column
			foreach (range(1,9) as $column) {

				$cell = Cell::getInstance($row, $column);
				$regionId = Region::getIdByCoordinate($row, $column);

				$this->rows[$row]->addCell($cell);
				$this->columns[$column]->addCell($cell);
				$this->regions[$regionId]->addCell($cell);

				$cell->attach($this);

                $this->grid[$row][$column] = $cell;
			}
		}
	}

    /**
     * @param \SplSubject $subject
     */
    public function update(\SplSubject $subject)
    {
        if ($subject instanceof Cell) {
            if ($subject->hasValue()) {
                $this->numberPlaced++;

	            $coordinate = $subject->getCoordinate();

	            $regionId = Region::getIdByCoordinate($coordinate->getRow(), $coordinate->getColumn());

	            $cellSetList = [];

	            if (!empty($this->rows[$coordinate->getRow()])) {
		            $cellSetList[] = $this->rows[$coordinate->getRow()];
	            }

	            if (!empty($this->columns[$coordinate->getColumn()])) {
		            $cellSetList[] = $this->columns[$coordinate->getColumn()];
	            }

	            if (!empty($this->regions[$regionId])) {
		            $cellSetList[] = $this->regions[$regionId];
	            }

	            foreach ($cellSetList as $set) {
		            /** @var Set $set */
		            $set->deleteCandidate($subject->getValue());
	            }

                if ($this->numberPlaced == 81) {

                }

                return ;
            }
        }

	    if ($subject instanceof Row) {
		    foreach ($this->rows as $key => $row) {
			    if ($row == $subject) {
				    unset($this->rows[$key]);
			    }
		    }
	    }

	    if ($subject instanceof Column) {
		    foreach ($this->columns as $key => $column) {
				if ($column == $subject) {
					unset($this->columns[$key]);
				}
		    }
	    }

	    if ($subject instanceof Region) {
		    foreach ($this->regions as $key => $region) {
			    if ($region == $subject) {
				    unset($this->regions[$key]);
			    }
		    }
	    }

    }

	public function getRows()
	{
		return $this->rows;
	}

	public function getColumns()
	{
		return $this->columns;
	}

	public function getRegions()
	{
		return $this->regions;
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