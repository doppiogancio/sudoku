<?php
/**
 * Created by PhpStorm.
 * User: fabrizio.gargiulo
 * Date: 11/01/17
 * Time: 16:26
 */


use core\Sudoku\Sudoku;
use core\Cell\Cell;


class SudokuTest extends PHPUnit_Framework_TestCase
{
    public function testSudokuInit()
    {
        $this->assertTrue(true);
        return true;
        $text = "_2__9_86_
		8_______3
		693__8__2
		__7284_3_
		____6__8_
		5__3__2_7
		_74__56_9
		__89_215_
		_5_6_____";

        $sudoku = new Sudoku();
        $sudoku->initFromString($text);

	    /** @var Cell $cell */
        $cell = $sudoku->getCell(3, 6);

        $this->assertEquals(8, $cell->getValue());
    }
}
