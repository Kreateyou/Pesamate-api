<?php
require "vendor/autoload.php";
use Pesamate\Models\Order;
use Pesamate\Models\Customer;
use Pesamate\Models\Account;
use Pesamate\Models\Auth;
use Pesamate\Models\Payment;
use Pesamate\Pesamate;
use Pesamate\Interfaces\TokenSession;
use Pesamate\Lib\Notification;
class Session implements TokenSession{
    public function set($key,$value){
      
    }
    public function get($key){

    }
}
/**
* 
*/
class Notifier extends Notification
{
	
	public function email():array{
		return [
		  // 'to'       =>'{customer_email}',
		  'message'  =>'Hello {customer_name} <br> Please pay Kes {order_amount}/= by clicking on the link below {payment_link}',
		  'subject'  =>'Mpesa Intergration & Maintenance',
		  'from'     =>'Kreateyou Kenya',
		];
	}

    public function sms():array{
       return [
          // 'to'=>'{customer_phone}',
          'message'=>'Hello {customer_name} Pay Kes {order_amount}/= for the Mpesa Intergration & Maintenance by clicking on this link {payment_link}',
       ];
    }
} 
$order     = new Order(uniqid(),5000,"Mpesa Intergration"); //254726863494
$customer  = new Customer("Newton Mwaniki","newtonmwaniki27@gmail.com","254705939985");
$customer2  = new Customer("Elijah Mwangi","emwangi.g@gmail.com","254723681977");

// $auth = Auth::withCredentials("emwangi.g@gmail.com","nifty");
$auth = Auth::withCredentials("info@pesamate.com","nifty");
$auth->setTokenSession(new \Session);


$account   = new Account();
$url  = ['http://kreateyou.co.ke/sync.php'];
$ecallback=function($reponse){
	print_r($reponse->getMessage());
	exit("\nError");
};
$callback=function($reponse){
	print_r($reponse);
};

$account->withMpesaStk()->depositMoneyToAccountAlias("PINT01");

Pesamate::requestBuilder($auth)         
         ->paymentForOrder($order)
	     ->from($customer2)
	     ->withAccount($account)
	     ->notifyCustomerVia(new Notifier())
	     ->onSuccess($callback)
	     ->onError($ecallback)
	     ->thenPing($url)// || thenOnlyPing()
	     ->requestPayment();
