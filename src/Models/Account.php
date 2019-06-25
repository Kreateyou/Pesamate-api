<?php
namespace Pesamate\Models;
use Pesamate\Interfaces\Notifier;
class Account{
	public $id;
	public $gateway;
	public $sub_gateway;
	public $ac_number;
	public $ac_number_alias;
	public $custom_name;
	public $notifier;


    /**
	* Identify the gateway to be used to request for payment STK
	**/
	public function withMpesaStk()
	{
		$this->sub_gateway="stk";
		$this->gateway="mpesa";
		return $this;
	}
	/**
	* Identify the gateway to be used to request for payment
	**/
	public function withMpesa()
	{
		$this->sub_gateway=null;
		$this->gateway="mpesa";
		return $this;
	}
	/**
	* Identify the gateway to be used to request for payment
	**/
	public function withStripe()
	{
		$this->sub_gateway=null;
		$this->gateway="mpesa";
		return $this;
	}
	/**
	* Identify the gateway to be used to request for payment
	**/
	public function withAirtelMoney()
	{
		$this->sub_gateway=null;
		$this->gateway="mpesa";
		return $this;
	}
	/**
	* Identify the gateway to be used to request for payment
	**/
	public function withTigo()
	{
		$this->sub_gateway=null;
		$this->gateway="mpesa";
		return $this;
	}
	/**
	* Identify the gateway to be used to request for payment
	**/
	public function withMpesaBulk()
	{
		$this->sub_gateway='b2c';
		$this->gateway="mpesa";
		return $this;
	}
	/**
	* Identify client account to have money deposited to by thier clients through A/C number 
	**/
	public function fromAccount($account)
	{
		$this->ac_number=$account;
		return $this;
	}
	/**
	* Identify client account to have money deposited to by thier clients through A/C number 
	**/
	public function widthdrawMoneyFromAccount($account)
	{
		$this->ac_number=$account;
		return $this;
	}
	/**
	* Identify client account to have money deposited to by thier clients through A/C number 
	**/
	public function depositMoneyToAccount($account)
	{
		$this->ac_number=$account;
		return $this;
	}
	/**
	* Identify client account to have money deposited to by thier clients through A/C Alias 
	**/
	public function depositMoneyToAccountAlias($account)
	{
		$this->ac_number_alias=$account;
		return $this;
	}
	/**
	* Identify client account to have money deposited to by thier clients through A/C Alias 
	**/
	public function widthdrawMoneyFromAccountAlias($account)
	{
		$this->ac_number_alias=$account;
		return $this;
	}
	/**
	* Identify client account to have money deposited to by thier clients through ID 
	**/
	public function depositMoneyToAccountId($id)
	{
		$this->id=$id;
		return $this;
	}
	/**
	* Allow customer to be notified/prompted to pay
	**/
	public function notifyClientVia(Notifier $notifier)
	{
		$this->notifier=$notifier;
		return $this;
	}

}