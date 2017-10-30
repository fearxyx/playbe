<?php
namespace App\src\dataApi\requests;


use App\src\TpMerchantConfig;
use App\src\TpUtils;

class TpDataApiRequestFactory {

	/**
	 * @param string $operation
	 * @param array $data
	 * @return TpDataApiRequest
	 */
	public static function getRequest($operation, TpMerchantConfig $config, array $data) {
		/** @var TpDataApiRequest $className Only class name. */
		$className = preg_replace(
			array('/^get(.+)$/', '/^set(.+)$/'),
			array('TpDataApiGet$1Request', 'TpDataApiSet$1Request'),
			$operation
		);

		$fileName = $className . '.php';
		TpUtils::requirePaths(array(
			array('dataApi', 'requests', $fileName)
		));

		$request = $className::createWithConfig($config, $data);
		return $request;
	}

}