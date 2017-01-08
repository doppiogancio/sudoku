<?php

define('BASE_PATH', realpath(dirname(__FILE__)));

function my_autoloader($class)
{
	$filename = BASE_PATH . '/' . str_replace('\\', '/', $class) . '.php';

	//var_dump($filename);

	//echo sprintf("%s\n<br>", $filename);
	include($filename);
}

spl_autoload_register('my_autoloader');