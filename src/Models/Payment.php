<?php
namespace Pesamate\Models;
/**
* 
*/
class Payment
{
   
	public $allocated_amount;
	public $default_currency="KES";
	public $note;
	public $ref;
	//gateway settings to ovveride account global config
	public $gateway="mpesa";
	public $sub_gateway ="";
	
	public function __construct($amount,$currency="KES",$ref=null)
	{
		$this->allocated_amount = $amount;
		$this->default_currency = $currency;
		if(is_null($ref)){
			$this->ref = uniqid();
		}else{
			$this->ref = $ref;
		}
	}
	public function allocateAmount($amount)
	{
		$this->allocated_amount = $amount;
		return $this;
	}
	public function setCurrency($currency='KES')
	{
		$this->default_currency = $currency;
		return $this;
	}
	public function for($note='Payment')
	{
		$this->note = $note;
		return $this;
	}
}