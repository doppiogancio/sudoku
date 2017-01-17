<?php

namespace core\Strategy;

use core\Set\Set;
use core\Cell\Cell;

class Strategy
{
	/**
	 * @param $number
	 *
	 * @throws \core\Exception\WrongValueException
	 */
	protected function executeStrategy($set, $number)
	{
		$cellCandidates = [];

		foreach ($set->getCells() as $cell) {
			/** @var Cell $cell */
			if ($cell->hasValue() && $cell->getValue() == $number) {
				break;
			}

			if ($cell->hasValue()) {
				continue;
			}

			if ($cell->hasCandidate($number)) {
				$cellCandidates[] = $cell;
			}
		}

		if (count($cellCandidates) === 1) {
			/** @var Cell $cell */
			$cell = $cellCandidates[0];
			$cell->setValue($number);
		}
	}

	/**
	 * @param Set[] $sets
	 */
	public function execute(array $sets)
	{
		foreach (range(1,9) as $number) {
			foreach ($sets as $set) {
				$this->executeStrategy($set, $number);
			}
		}

		return $this;
	}
}