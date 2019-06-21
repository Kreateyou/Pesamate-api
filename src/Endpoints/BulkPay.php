<?php
namespace Pesamate\Endpoints;

use Pesamate\Interfaces\Endpoint;

class BulkPay extends Endpoint{
    public function getRoute(){ 
      return "wallet/bulkpay";
    }
	public function isBackgroundEnabled(){
		return true;
	}
}