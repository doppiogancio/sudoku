<?php

namespace core\Log;


use Prophecy\Exception\Exception;

class Log
{
	static $text;

	static public function addLine($type, $message)
	{
		$date = date("H:i:s");
		list($milliseconds, $seconds) = explode(" ", microtime());

		$milliseconds = round($milliseconds * 1000);

		self::$text .= sprintf("%s %d | %s | %s<br>", $date, $milliseconds, $type, $message);
	}

	static public function addDefault($message)
	{
		self::addLine('<span class="label label-default">Default</span>', $message);
	}

	static public function addPrimary($message)
	{
		self::addLine('<span class="label label-primary">Primary</span>', $message);
	}

	static public function addSuccess($type = 'Success', $message)
	{
		self::addLine('<span class="label label-success">' . $type . '</span>', $message);
	}

	static public function addInfo($type = 'Info', $message)
	{

		self::addLine('<span class="label label-info">' .$type. '</span>', $message);
	}

	static public function addWarning($message)
	{
		self::addLine('<span class="label label-warning">Warning</span>', $message);
	}

	static public function addDanger($message)
	{
		self::addLine('<span class="label label-danger">Danger</span>', $message);
	}

	static public function addException(\Exception $exception)
	{
		self::addLine(sprintf('<span class="label label-danger">%s</span>', get_class($exception)), $exception->getMessage());
	}

	static public function get()
	{
		return self::$text;
	}

	static public function print()
	{
		print self::$text;
	}
}