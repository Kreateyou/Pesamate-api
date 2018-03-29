<?php
namespace Pesamate\Endpoints;

use Pesamate\Interfaces\Endpoint;

class SendAirtime extends Endpoint{
    public function getRoute(){ 
      return "request/airtime";
    }
	public function isBackgroundEnabled(){
		return true;
	}
}