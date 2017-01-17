<?php

require_once 'config.php';

define('BASE_PATH', realpath(dirname(__FILE__)));

function my_autoloader($class)
{
	$filename = BASE_PATH . '/' . str_replace('\\', '/', $class) . '.php';

	@include($filename);
}

spl_autoload_register('my_autoloader');

function dump($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}