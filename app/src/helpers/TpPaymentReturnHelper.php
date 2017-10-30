<?php
namespace App\src\helpers;

use SoapClient;
use App\src\TpMerchantConfig;
use App\src\TpPaymentReturnResponse;
use App\src\exceptions\TpException;

/**
 * @author Michal Kandr
 */
class TpPaymentReturnHelper {
	protected static function getSignature($data) {
		return md5(http_build_query(array_filter($data)));
	}
	
	public static function returnPayment(TpMerchantConfig $config, $paymentId, $reason = null){
		$client = new SoapClient($config->webServicesWsdl, ['cache_wsdl' => WSDL_CACHE_NONE]);
		$signature = static::getSignature(array(
			'merchantId'   => $config->merchantId,
			'accountId'    => $config->accountId,
			'paymentId'    => $paymentId,
			'reason'       => $reason,
			'password'     => $config->password
		));
		$result = $client->returnPaymentRequest(array(
			'merchantId'   => $config->merchantId,
			'accountId'    => $config->accountId,
			'paymentId'    => $paymentId,
			'reason'       => $reason,
			'signature'    => $signature
		));
		if( ! $result){
			throw new TpException();
		}
		return new TpPaymentReturnResponse($result);
	}
}
