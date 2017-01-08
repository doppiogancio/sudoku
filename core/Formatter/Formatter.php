<?php
/**
 * Created by PhpStorm.
 * User: fabriziogargiulo
 * Date: 08/01/17
 * Time: 15:33
 */

namespace core\Formatter;

use core\Sudoku\Sudoku;

abstract class Formatter {
	protected $sudoku;

	public function __construct(Sudoku $sudoku)
	{
		$this->sudoku = $sudoku;
	}

	abstract  public function getOutput();
}