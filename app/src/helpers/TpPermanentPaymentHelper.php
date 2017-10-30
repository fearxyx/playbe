<?php
namespace App\src\helpers;

use SoapClient;
use App\src\TpPermanentPayment;
use App\src\TpPermanentPaymentResponse;
use App\src\exceptions\TpException;


/**
 *
 * @author Michal Kandr
 */
class TpPermanentPaymentHelper {
	public static function createPermanentPayment(TpPermanentPayment $payment){
		$config = $payment->getConfig();
		$client = new SoapClient(
			$config->webServicesWsdl,
			array('features' => SOAP_SINGLE_ELEMENT_ARRAYS)
		);
		$result = $client->createPermanentPaymentRequest(array(
			'merchantId'   => $config->merchantId,
			'accountId'    => $config->accountId,
			'merchantData' => $payment->getMerchantData(),
			'description'  => $payment->getDescription(),
			'returnUrl'    => $payment->getReturnUrl(),
			'signature'    => $payment->getSignature()
		));
		if( ! $result){
			throw new TpException();
		}
		return new TpPermanentPaymentResponse($result);
	}

	public static function getPermanentPayment(TpPermanentPayment $payment){
		$config = $payment->getConfig();
		$client = new SoapClient(
			$config->webServicesWsdl,
			array('features' => SOAP_SINGLE_ELEMENT_ARRAYS)
		);
		$result = $client->getPermanentPaymentRequest(array(
			'merchantId'   => $config->merchantId,
			'accountId'    => $config->accountId,
			'merchantData' => $payment->getMerchantData(),
			'signature'    => $payment->getSignatureLite()
		));
		if( ! $result){
			throw new TpException();
		}
		return new TpPermanentPaymentResponse($result);
	}
}
