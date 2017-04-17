<?php

namespace Bagus\PCPExpress;

use Requests;

class PCPExpress
{

	CONST URL = 'http://27.123.221.139';
	
	private $username = 'pcpapi_online';
	private $password = 'Pcpapi_online123';

	public function setCredentials($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
		return $this;
	}
	
	public function getOriginAndDestination()
	{
		$response = Requests::get(self::URL . '/pcp.api/regiononline.php', [], $this->_getOptions());
		if (isset($response->body)) {
			return json_decode($response->body);
		}
	}

	public function deliveryCharge($from, $thru, $weight) {
		return Requests::post(self::URL . '/pcp.api/serviceonline.php', [], ['from' => $from, 'thru' => $thru, 'weight' => $weight], $this->_getOptions());
	}
	
	private function _getOptions() {
		return [
			'auth' => [$this->username, $this->password]
		];
	}

}
