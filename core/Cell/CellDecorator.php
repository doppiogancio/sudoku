<?php

namespace core\Cell;

use core\Set\Region;
use core\Sudoku\Sudoku;

class CellDecorator
{
	protected $cell;

	public function __construct(Cell $cell)
	{
		$this->cell = $cell;
	}

	static public function build($cell)
	{
		return new self($cell);
	}

	public function getClassList(array $classList = [])
	{
		$row = $this->cell->getCoordinate()->getRow();
		$column = $this->cell->getCoordinate()->getColumn();

		$classList[] = "row-".$row;
		$classList[] = "column-".$column;
		$classList[] = "region-".Region::getIdByCoordinate($row, $column);

		$classList[] = "cell";

		return $classList;
	}

	public function printClassList(array $classList = [], $glue = ' ')
	{
		print implode($glue, $this->getClassList($classList));
	}
}