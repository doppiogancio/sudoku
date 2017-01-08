<?php

namespace core\Queue;

use core\Cell\Cell;


class Queue {
	protected $queue;

	public function __construct()
	{
		//$item = array_shift($list);
		$this->queue = [];
	}

	public function isEmpty()
	{
		return empty($this->queue);
	}

	public function push(Cell $cell)
	{
		echo sprintf(
			"Pushing to queue cell(%d,%d)\n",
			$cell->getCoordinate()->getRow(),
			$cell->getCoordinate()->getColumn()
		);

		$this->queue[] = $cell;
	}

	public function shift()
	{
		return array_shift($this->queue);
	}
}