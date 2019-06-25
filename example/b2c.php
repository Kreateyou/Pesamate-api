<?php
//Allow payment from wallet
require "vendor/autoload.php";
use Pesamate\Models\Auth;
use Pesamate\Interfaces\TokenSession;
use Pesamate\Models\UserAccount;
use Pesamate\Pesamate;
use Pesamate\Models\Customer;
use Pesamate\Models\Payment;
use Pesamate\Models\Account;

//File Based Cache
class FileCache implements TokenSession{
    public function set($key,$value){
    	$data=[];
    	
      if(is_file("data/session.log")){
      	$data = json_decode(file_get_contents("data/session.log"),1);
      }
      $data[$key] = $value;
      file_put_contents("data/session.log", json_encode($data));
    }
    public function get($key){

    	if(is_file("data/session.log")){ 
	      	$data = json_decode(file_get_contents("data/session.log"),1);
	      	return isset($data[$key])?$data[$key]:null;
	    }

        return null;
    }
}
$ecallback=function($reponse){
	print_r($reponse->getMessage());
	exit("\nError");
};
$callback=function($reponse){
	print_r($reponse);
};
// $auth = Auth::withCredentials("info@pesamate.com","nifty");
$auth = Auth::withCredentials("emwangi.g@gmail.com","nifty@20#");

//Customer Information
$customer  = new Customer("Virg Iniah","virg@pesamate.com","254723681977");
$customerw  = new Customer("Abila M","virg@ab.com","254725720822");
//Account Information
$account   = new Account();
$account->fromAccount("5000142573073233")
        ->withMpesaBulk();

//Payment Information
$payment = new Payment(20);
$payment->for("Testing Mpesa B2C");

Pesamate::requestBuilder($auth)         
         ->payment($payment)	
         ->fromAccount($account) 
         ->to($customer) 
         ->to($customerw)     
	     ->onSuccess($callback)
	     ->onError($ecallback)
       ->thenPing("https://www.pesamate.com/api/z")
	     ->BulkPay();  

	     exit();