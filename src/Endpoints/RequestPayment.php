<?php

namespace Pesamate\Endpoints;
use Pesamate\Interfaces\Endpoint;

class RequestPayment extends Endpoint{
    public function getRoute(){ 
      return "request/payment";
    }
	public function isBackgroundEnabled(){
		return true;
	}
}