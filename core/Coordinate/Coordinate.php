<?php

namespace core\Coordinate;

class Coordinate
{
	protected $row;
	protected $column;

	public function __construct($row, $column)
	{
		$this->row = $row;
		$this->column = $column;
	}

	public function getRow()
	{
		return $this->row;
	}

	public function getColumn()
	{
		return $this->column;
	}
}