<?php
namespace Pesamate\Models;
/**
* 
*/
class UserAccount
{
	public $email;
    public $phone;
    public $name;
    public $surname;
    public $username;
    public $sms_contract=false;
	
	function __construct($argument)
	{
		foreach ($argument as $key=>$value) {
		  if(property_exists($this, $key)){
		  	$this->{$key}=$value;
		  }
		}
	}
}