<?php

namespace Pesamate\Endpoints;
use Pesamate\Interfaces\Endpoint;

class CreateAccount extends Endpoint{
    public function getRoute(){
      return "user/create";
    }
	public function isBackgroundEnabled(){

	}
}