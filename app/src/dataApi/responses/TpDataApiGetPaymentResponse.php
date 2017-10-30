<?php
namespace App\src\dataApi\responses;


use App\src\dataApi\parameters\TpDataApiPayment;

class TpDataApiGetPaymentResponse extends TpDataApiResponse {

	protected static $dateTimePaths = array(
		array('payment', 'createdOn'),
		array('payment', 'finishedOn'),
		array('payment', 'canceledOn')
	);

	/**
	 * @var TpDataApiPayment|null
	 */
	protected $payment;

	/**
	 * @param array $response
	 * @return TpDataApiGetPaymentResponse
	 */
	public static function createFromResponse(array $response) {
		/** @var TpDataApiGetPaymentResponse $instance */
		$instance = parent::createFromResponse($response);

		$payment = new TpDataApiPayment($response['payment']);
		$instance->setPayment($payment);

		return $instance;
	}

	/**
	 * @return TpDataApiPayment|null
	 */
	public function getPayment() {
		return $this->payment;
	}

	/**
	 * @param TpDataApiPayment|null $payment
	 */
	public function setPayment(TpDataApiPayment $payment = null) {
		$this->payment = TpValueFormatter::format('TpDataApiPayment', $payment);
	}

}
