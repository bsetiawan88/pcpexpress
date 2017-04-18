<?php

namespace Bagus\PCPExpress;

use Requests;

class PCPExpress
{

	CONST URL = 'http://27.123.221.139';

	private $username = 'pcpapi_online';
	private $password = 'Pcpapi_online123';
	private $originAndDestination;

	public function setCredentials($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
		return $this;
	}

	public function getOriginAndDestination()
	{
		if (empty($this->originAndDestination)) {
			$response = Requests::get(self::URL . '/pcp.api/regiononline.php', [], $this->_getOptions());
			if (isset($response->body)) {
				$this->originAndDestination = json_decode($response->body);
			}
		}

		return $this->originAndDestination;
	}

	public function deliveryCharge($from, $thru, $weight)
	{
		return Requests::post(self::URL . '/pcp.api/serviceonline.php', [], ['from' => $from, 'thru' => $thru, 'weight' => $weight], $this->_getOptions());
	}

	public function postShipment($params)
	{
		return Requests::post(self::URL . '/pcp.api/ecommerce/service/training/posonline.php', [], $params, $this->_getOptions());
	}
	
	public function checkShipment($awb) {
		$response = Requests::get(self::URL . '/pcp.api/en/trackingonline.php?noawb=' . $awb, [], $this->_getOptions());
		return $response->body;
	}
	
	public function getShipmentDataTemplate() {
		return [
			'allocation_code' => '',
			'shipment_date_string' => '',
			'shipment_time_string' => '',
			'unique_reference_no' => '',
			'company_id' => '',
			'company_name' => '',
			'city_origin_code' => '',
			'city_origin_name' => '',
			'city_destination_code' => '',
			'city_destination_name' => '',
			'service_code' => '',
			'service_name' => '',
			'quantity' => '',
			'weight' => '',
			'insurance_flag' => '',
			'goods_value_are' => '',
			'goods_description' => '',
			'shipper_name' => '',
			'shipper_province_name' => '',
			'shipper_district_name' => '',
			'shipper_subdistrict_name' => '',
			'shipper_postal_code' => '',
			'shipper_address' => '',
			'shipper_handphone_number' => '',
			'shipper_contact' => '',
			'recipient_name' => '',
			'recipient_province_name' => '',
			'recipient_district_name' => '',
			'recipient_subdistrict_name' => '',
			'recipient_postal_code' => '',
			'recipient_address' => '',
			'recipient_handphone_number' => '',
			'recipient_contact' => ''
		];
	}

	private function _getOptions()
	{
		return [
			'auth' => [$this->username, $this->password]
		];
	}

}
