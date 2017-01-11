<?php
/**
 * Created by PhpStorm.
 * User: fabriziogargiulo
 * Date: 11/01/17
 * Time: 22:10
 */

namespace core\Exception;


class LastCandidateException extends CoreException
{
	public function __construct( ) {
		parent::__construct( "LastCandidateException" );
	}
}