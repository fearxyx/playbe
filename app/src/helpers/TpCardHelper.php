<?php
namespace App\src\helpers;


use SoapClient;
use App\src\exceptions\TpException;
use App\src\TpCardPaymentResponse;
use App\src\TpMerchantConfig;


/**
 * @author Michal Kandr
 */
class TpCardHelper {
	protected static function getSignature($data) {
		return md5(http_build_query(array_filter($data)));
	}

	public static function depositPayment(TpMerchantConfig $config, $merchantData){
		$client = new SoapClient($config->webServicesWsdl);
		$signature = static::getSignature(array(
			'merchantId'   => $config->merchantId,
			'accountId'    => $config->accountId,
			'merchantData' => $merchantData,
			'password'     => $config->password
		));
		$result = $client->cardDepositPaymentRequest(array(
			'merchantId'   => $config->merchantId,
			'accountId'    => $config->accountId,
			'merchantData' => $merchantData,
			'signature'    => $signature
		));
		if( ! $result){
			throw new TpException();
		}
		return new TpCardPaymentResponse($result);
	}

	public static function stornoPayment(TpMerchantConfig $config, $merchantData){
		$client = new SoapClient($config->webServicesWsdl);
		$signature = static::getSignature(array(
			'merchantId'   => $config->merchantId,
			'accountId'    => $config->accountId,
			'merchantData' => $merchantData,
			'password'     => $config->password
		));
		$result = $client->cardStornoPaymentRequest(array(
			'merchantId'   => $config->merchantId,
			'accountId'    => $config->accountId,
			'merchantData' => $merchantData,
			'signature'    => $signature
		));
		if( ! $result){
			throw new TpException();
		}
		return new TpCardPaymentResponse($result);
	}

	public static function createNewRecurrentPayment(TpMerchantConfig $config, $merchantData, $newMerchantData, $value){
		$client = new SoapClient($config->webServicesWsdl);
		$signature = static::getSignature(array(
			'merchantId'      => $config->merchantId,
			'accountId'       => $config->accountId,
			'merchantData'    => $merchantData,
			'newMerchantData' => $newMerchantData,
			'value'           => $value,
			'password'        => $config->password,
		));

		$result = $client->cardCreateRecurrentPaymentRequest(array(
			'merchantId'      => $config->merchantId,
			'accountId'       => $config->accountId,
			'merchantData'    => $merchantData,
			'newMerchantData' => $newMerchantData,
			'value'           => $value,
			'signature'       => $signature
		));
		if( ! $result){
			throw new TpException();
		}
		return new TpCardPaymentResponse($result);
	}

}
