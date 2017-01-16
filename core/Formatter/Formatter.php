<?php

namespace core\Formatter;

use core\Sudoku\Sudoku;

abstract class Formatter
{
	protected $sudoku;

	public function __construct(Sudoku $sudoku)
	{
		$this->sudoku = $sudoku;
	}

	abstract  public function getOutput();
}