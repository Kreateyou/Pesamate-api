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
	
	public function __construct($amount,$currency="KES")
	{
		$this->allocated_amount = $amount;
		$this->default_currency = $currency;
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