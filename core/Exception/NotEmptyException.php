<?php

namespace core\Exception;

use core\Exception\CoreException;


class NotEmptyException extends CoreException
{
	public function __construct( $message ) {
		parent::__construct( $message );
	}
}