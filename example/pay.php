<?php
require "vendor/autoload.php";
use Pesamate\Models\Auth;
use Pesamate\Interfaces\TokenSession;
use Pesamate\Models\UserAccount;
use Pesamate\Pesamate;
use Pesamate\Models\Customer;
use Pesamate\Models\Payment;
use Pesamate\Models\Account;

class Session implements TokenSession{
    public function set($key,$value){
      
    }
    public function get($key){

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
$auth = Auth::withCredentials("emwangi.g@gmail.com","nifty");

$customer2  = new Customer("Virginia Nduta Mwaniki","virg@gmail.com","254720538079");
$customer  = new Customer("Elijah Mwangi","emwangi.g@gmail.com","254723681977");
$account   = new Account();
$account->fromAccount("5000349987401903");
$payment = new Payment(10);
$payment->for("Purchase of Fruits and vegetables");
Pesamate::requestBuilder($auth)         
         ->payment($payment)	
         ->fromAccount($account)     
	     ->onSuccess($callback)
	     ->onError($ecallback)
	     ->Pay();  

	     exit();