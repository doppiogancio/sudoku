<?php

namespace core\Exception;


class WrongValueException extends CoreException
{
	public function __construct( ) {
		parent::__construct( "WrongValueException" );
	}
}