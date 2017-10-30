<?php
namespace App\src\exceptions;



class TpMissingParameterException extends TpInvalidParameterException {
	function __construct($parameter) {
		parent::__construct($parameter);

		$this->message = "Missing parameter ".$parameter;
	}
}
