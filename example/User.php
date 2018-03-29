<?php
require "vendor/autoload.php";
use Pesamate\Models\Auth;
use Pesamate\Interfaces\TokenSession;
use Pesamate\Models\UserAccount;
use Pesamate\Pesamate;
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
$auth->setTokenSession(new \Session);

$user = new UserAccount(["email"=>"info@kreateyou.co.ke","phone"=>"0723681977","name"=>"Pesamate Team","username"=>"XYZ","sms_contract"=>true]);
Pesamate::requestBuilder($auth)         
         ->withUser($user)	     
	     ->onSuccess($callback)
	     ->onError($ecallback)
	     ->CreateAccount();  

	     exit();