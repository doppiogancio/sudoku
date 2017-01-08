<?php
/**
 * Created by PhpStorm.
 * User: fabriziogargiulo
 * Date: 08/01/17
 * Time: 17:45
 */

namespace core\Strategy;

use core\Sudoku\Sudoku;

abstract class Strategy {

	protected $sudoku;

	public function __construct(Sudoku $sudoku)
	{
		$this->sudoku = $sudoku;
	}

	abstract public function execute();
}