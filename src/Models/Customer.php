<?php
namespace Pesamate\Models;

class Customer{
	public $names;
	public $phone;
	public $email;
	public $id;	
	public $payment_instructions;

	public function __construct($name,$email,$phone)
	{
		$this->names = $name;
		$this->email = $email;
		$this->phone = $phone;
	}
	public function setPaymentInstructions(Payment $model)
	{
		$this->payment_instructions = $model;
		return $this;
	}
}