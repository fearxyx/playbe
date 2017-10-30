<?php
namespace App\src\dataApi\responses;


use App\src\dataApi\parameters\TpDataApiPaymentInfo;

class TpDataApiGetPaymentInstructionsResponse extends TpDataApiResponse {

	/**
	 * @var TpDataApiPaymentInfo|null
	 */
	protected $paymentInfo;

	/**
	 * @param array $response
	 * @return TpDataApiGetPaymentInstructionsResponse
	 */
	public static function createFromResponse(array $response) {
		/** @var TpDataApiGetPaymentInstructionsResponse $instance */
		$instance = parent::createFromResponse($response);

		$paymentInfo = new TpDataApiPaymentInfo($response['paymentInfo']);
		$instance->setPaymentInfo($paymentInfo);

		return $instance;
	}

	/**
	 * @return TpDataApiPaymentInfo|null
	 */
	public function getPaymentInfo() {
		return $this->paymentInfo;
	}

	/**
	 * @param TpDataApiPaymentInfo|null $paymentInfo
	 */
	public function setPaymentInfo(TpDataApiPaymentInfo $paymentInfo = null) {
		$this->paymentInfo = TpValueFormatter::format(
			'TpDataApiPaymentInfo', $paymentInfo
		);
	}

}
