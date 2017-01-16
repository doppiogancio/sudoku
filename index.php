<?php

require_once "loader.php";

use core\Set\Row;
use core\Sudoku\SudokuSummerExpert;
use core\Formatter\FormatterGrid;
use core\Formatter\FormatterTabbedGridWithCandidates;

try {
	ini_set('display_errors',1);
	error_reporting(E_ALL|E_STRICT|E_ERROR | E_PARSE);
	ini_set('error_log','script_errors.log');
	ini_set('log_errors','On');
	$row = new Row();
	die('xxxasa');

	$sudoku = new \core\Sudoku\SudokuSummerExpert();

	$formatter = new FormatterGrid($sudoku);
	$formatterWithCandidates = new FormatterTabbedGridWithCandidates($sudoku);

	// Number placed: 25

	print $formatter->getOutput();

	//print $formatterWithCandidates->getOutput();
}
catch (Exception $e) {
	print $e->getTraceAsString()."\n";
	die($e->getMessage()."\n");
}