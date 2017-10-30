<?php
namespace App\src\exceptions;



/**
 * Exception thrown when payment signature validation failed.
 */
class TpInvalidSignatureException extends TpException {
	function __construct() {
		parent::__construct("Invalid signature");
	}
}
