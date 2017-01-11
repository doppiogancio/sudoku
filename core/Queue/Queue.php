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
		$this->queue[] = $cell;
	}

	public function shift()
	{
		return array_shift($this->queue);
	}
}