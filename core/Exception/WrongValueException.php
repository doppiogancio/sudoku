<?php

namespace core\Exception;


class WrongValueException extends CoreException
{
	public function __construct( $message = 'WrongValueException' ) {
		parent::__construct( $message );
	}
}