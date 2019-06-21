<?php
namespace Pesamate\Endpoints;

use Pesamate\Interfaces\Endpoint;

class B2C extends Endpoint{
    public function getRoute(){ 
      return "wallet/b2c";
    }
	public function isBackgroundEnabled(){
		return true;
	}
}