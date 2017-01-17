<?php

namespace core\Strategy;

use core\Set\Set;
use core\Cell\Cell;
use core\Log\Log;

class Strategy
{
	/**
	 * @param Set $set
	 * @param $number
	 *
	 * @throws \core\Exception\WrongValueException
	 */
	protected function executeStrategy(Set $set, $number)
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
			$text = sprintf("Trovato il candidato per <b>%s #%d</b>.", get_class($set), $set->getId());
			Log::addSuccess('Strategy', $text);

			/** @var Cell $cell */
			$cell = $cellCandidates[0];
			$cell->setValue($number);
		}
	}

	/**
	 * @param array $sets
	 *
	 * @return $this
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