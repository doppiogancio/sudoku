<?php

define ('SUDOKU_DEFAULT_CELL_VALUE', '_');

require_once "loader.php";

use core\Sudoku\SudokuSummerExpert;
use core\Formatter\FormatterGrid;
use core\Formatter\FormatterTabbedGridWithCandidates;
use core\Strategy\StrategyRowFiller;
use core\Strategy\StrategyColumnFiller;
use core\Strategy\StrategyRegionFiller;

try {
	$sudoku = new SudokuSummerExpert();

	$formatter = new FormatterGrid($sudoku);
	$formatterWithCandidates = new FormatterTabbedGridWithCandidates($sudoku);

	// Number placed: 25
	$sudoku->applyStrategies();


	print $formatter->getOutput();

	//print $formatterWithCandidates->getOutput();
}
catch (Exception $e) {
	die($e->getMessage());
}