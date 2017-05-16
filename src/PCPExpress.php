<?php

namespace Bagus\PCPExpress;

use Requests;

class PCPExpress
{

	private $username;
	private $password;
	private $url;
	private $url_path;
	private $originAndDestination;

	public function setCredentials($username, $password, $url, $url_path)
	{
		$this->username = $username;
		$this->password = $password;
		$this->url = $url;
		$this->url_path = $url_path;
		return $this;
	}

	public function getOriginAndDestination()
	{
		if (empty($this->originAndDestination)) {
			$response = Requests::get($this->url . '/pcp.api/regiononline.php', [], $this->_getOptions());
			if (isset($response->body)) {
				$this->originAndDestination = json_decode($response->body);
			}
		}

		return $this->originAndDestination;
	}

	public function deliveryCharge($from, $thru, $weight)
	{
		$response = Requests::post($this->url . '/pcp.api/serviceonline.php', [], ['from' => $from, 'thru' => $thru, 'weight' => $weight], $this->_getOptions());
		return json_decode($response->body);
	}

	public function postShipment($params)
	{
		$response =  Requests::post($this->url . '/pcp.api/ecommerce/service/' . $this->url_path . '/posonline.php', [], $params, $this->_getOptions());
		return json_decode($response->body);
	}

	public function checkShipment($awb)
	{
		$response = Requests::get($this->url . '/pcp.api/en/trackingonline.php?noawb=' . $awb, [], $this->_getOptions());
		return $response->body;
	}

	public function getShipmentDataTemplate()
	{
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
