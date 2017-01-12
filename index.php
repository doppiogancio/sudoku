<?php

require_once "loader.php";

use core\Sudoku\SudokuSummerExpert;
use core\Formatter\FormatterGrid;
use core\Formatter\FormatterTabbedGridWithCandidates;

try {
	$sudoku = new \core\Sudoku\SudokuSimple();

	$formatter = new FormatterGrid($sudoku);
	$formatterWithCandidates = new FormatterTabbedGridWithCandidates($sudoku);

	// Number placed: 25
	//$sudoku->applyStrategies();

	print $formatter->getOutput();

	//print $formatterWithCandidates->getOutput();
}
catch (Exception $e) {
	print $e->getTraceAsString()."\n";
	die($e->getMessage()."\n");
}