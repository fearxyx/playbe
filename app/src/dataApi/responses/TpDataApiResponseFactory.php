<?php

namespace App\src\dataApi\responses;


use App\src\dataApi\processors\TpDataApiSoapFlattener;
use App\src\dataApi\processors\TpDataApiDateTimeInflater;
use App\src\dataApi\parameters\TpDataApiSignature;
use App\src\exceptions\TpInvalidSignatureException;
use App\src\TpMerchantConfig;
use App\src\TpUtils;
use stdClass;

class TpDataApiResponseFactory {

	/**
	 * @param string $operation
	 * @param TpMerchantConfig $config
	 * @param stdClass $data
	 * @return TpDataApiResponse
	 * @throws TpInvalidSignatureException
	 */
	public static function getResponse($operation, TpMerchantConfig $config, stdClass $data) {
		/** @var string|TpDataApiResponse $className Only class name. */
		$className = preg_replace(
			array('/^get(.+)$/', '/^set(.+)$/'),
			array('TpDataApiGet$1Response', 'TpDataApiSet$1Response'),
			$operation
		);

		$fileName = $className . '.php';
		TpUtils::requirePaths(array(
			array('dataApi', 'responses', $fileName)
		));

		$array = TpUtils::toArrayRecursive($data);

		$listPaths = $className::listPaths();
		$flattened = TpDataApiSoapFlattener::processWithPaths(
			$array, $listPaths
		);

		TpDataApiSignature::validate($flattened, $config->dataApiPassword);

		$dateTimePaths = $className::dateTimePaths();
		$inflated = TpDataApiDateTimeInflater::processWithPaths(
			$flattened, $dateTimePaths
		);

		$response = $className::createFromResponse($inflated);
		return $response;
	}

}
