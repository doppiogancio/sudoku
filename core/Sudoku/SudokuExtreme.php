<?php
/**
 * Created by PhpStorm.
 * User: fabriziogargiulo
 * Date: 16/01/17
 * Time: 01:53
 */

namespace core\Sudoku;


class SudokuExtreme extends Sudoku
{
	public function __construct()
	{
		parent::__construct();

		$text = "3___8___4
		___5_1___
		__2_6_7__
		_6_____1_
		7_9_5_8_2
		_5_____7_
		__6_2_9__
		___4_8___
		4___1___3";

		$this->initFromString($text);
	}
}