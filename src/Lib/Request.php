<?php
namespace Pesamate\Lib;
use Closure;
use Exception;
use Pesamate\Models\Order;
use Pesamate\Models\Customer;
use Pesamate\Models\Account;
use Pesamate\Models\UserAccount;
use Pesamate\Models\Auth;
use Pesamate\Models\Payment;
use Pesamate\Models\CallbackInfo;
use Pesamate\Interfaces\Notifier;
class Request{
  public $auth;
  public $order;
  public $customer;
  public $customers=[];
  public $account;
  public $successCallback;
  public $errorCallback;
  public $callback;
  public $notifier;
  public $user_account=null;
  public $payment_instructions;

  public function __construct(Auth $auth)
  {
  	$this->auth = $auth;
  }
  public function resetSession($token)
  {
    $this->auth = Auth::withToken($token);
     return $this;
  }
  public function paymentForOrder(Order $order){
  	$this->order = $order;
    return $this;
  }
  public function withUser(UserAccount $userAccount)
  {
    $this->user_account = $userAccount;
    return $this;
  }
  public function to($customer){
    $this->customers[] = $customer;
    return $this;
  }
  public function from(Customer $customer){
  	$this->customer = $customer;
    return $this;
  }
  public function withAccount(Account $account){
  	$this->account = $account;
    return $this;
  }
  public function fromAccount(Account $account){
    $this->account = $account;
    return $this;
  }
  public function onSuccess(Closure $cb){
  	$this->successCallback = $cb;
    return $this;
  }
  public function onError(Closure $cb){
  	$this->errorCallback = $cb;
    return $this;
  }
  public function payment(Payment $cb){
    $this->payment_instructions = $cb;
    return $this;
  }
  public function notifyCustomerVia(Notifier $nt){
    $this->notifier = $nt;
    return $this;
  }
  /**
  * Allow the Pesamate Callback engine to ping back the following url
  * @param $urls array of urls or single url
  * @param method method type that your callback accepts
  * @param $custom_data to be passed alongside this ping
  * Note this will add a list of pingable url including one on the server
  **/
  public function thenPing($urls,$method="post",$custom_data=[],$error_url="",$override_server=false){
  	$this->callback = new CallbackInfo($urls,$override_server,$method,$custom_data);
    $this->onErrorPing($error_url);
    return $this;
  }

  /**
  * Allow the Pesamate Callback engine to ping back the following url
  * @param $urls array of urls or single url
  * @param method method type that your callback accepts
  * @param $custom_data to be passed alongside this ping
  * Note this will add a list of pingable url including one on the server
  **/
  protected function onErrorPing($url){
    $this->callback->addErrorUrl($url);
    return $this;
  }
  /**
  * Allow the Pesamate Callback engine to ping back the following url
  * @param $urls array of urls or single url
  * @param method method type that your callback accepts
  * @param $custom_data to be passed alongside this ping
  * Note this ovverides the server callback url and only execute this for this transaction
  **/
  public function thenOnlyPing($urls,$method="post",$custom_data=[]){
  	$this->callback = new CallbackInfo($urls,true,$method,$custom_data);
    return $this;
  }
  // public function createAccount(){
  	
  //   return $this;
  // }
  // public function getAccounts(){
  	
  //   return $this;
  // }
  // public function getBalance(){
  //   return $this;
  // }
  // public function getTransactions(){
  	
  //   return $this;
  // }
  // public function getAllTransactions(){
  	
  //   return $this;
  // }
  public function __call($method,$args)
  {
    $c = '\\Pesamate\\Endpoints\\'.ucfirst($method);
    if(class_exists($c)){
      return new $c($this);
    }
    $x = ucfirst($method);
    throw new Exception("$c Endpoint dont exists", 1);
    
  }
}