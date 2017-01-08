<?php

namespace core\Formatter;

use core\Cell\Cell;

class FormatterGrid extends Formatter {

	public function getOutput()
	{
		$numbersLeft = [
			1 => 9,
			2 => 9,
			3 => 9,

			4 => 9,
			5 => 9,
			6 => 9,

			7 => 9,
			8 => 9,
			9 => 9
		];

		$numbers = 0;
		$string = "|-------+-------+-------|\n";

		foreach ($this->sudoku->getGrid() as $key => $line) {
			$string .= "| ";

			foreach ($line as $col => $cell) {

				/** @var Cell $cell */
				$string .= sprintf("%s", $cell->getValue());

				if ($cell->hasValue()) {
					$numbers++;
					$numbersLeft[$cell->getValue()]--;
				}

				if ($col % 3 == 0) {
					$string .= " | ";
				}
				else {
					$string .= " ";
				}
			}

			$string .= "\n";

			if ($key % 3 == 0) {
				$string .= "|-------+-------+-------|\n";
			}
			else {
				//echo "_______________________\n";
			}
		}

		$string .= sprintf("Number placed: %d\n", $numbers);

		$string .= sprintf("Number left:\n");

		foreach ($numbersLeft as $number => $qt) {
			if ($qt == 0) continue;
			$string .= sprintf("%d => %d\n", $number, $qt);
		}


		return $string;
	}
}