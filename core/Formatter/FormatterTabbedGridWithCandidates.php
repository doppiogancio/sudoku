<?php

namespace core\Formatter;

class FormatterTabbedGridWithCandidates extends Formatter {

	public function getOutput()
	{
		$string = "\n";

		foreach ($this->sudoku->getGrid() as $key => $line) {
			foreach ($line as $col => $cell) {
				/** @var Cell $cell */

				if ($cell->hasCandidates()) {
					$string .= sprintf("%s;", implode(',', $cell->getCandidates()));
				}
				else {
					$string .= sprintf("%s;", $cell->getValue());
				}
			}

			$string .= "\n";
		}

		return $string;
	}
}