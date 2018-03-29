<?php
namespace Pesamate\Endpoints;

use Pesamate\Interfaces\Endpoint;

class Pay extends Endpoint{
    public function getRoute(){ 
      return "wallet/pay";
    }
	public function isBackgroundEnabled(){
		return true;
	}
}