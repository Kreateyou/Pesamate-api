<?php
namespace Pesamate\Models;
use pesamate\interfaces\TokenSession;
use Pesamate\Interfaces\Endpoint;
use GuzzleHttp\Client;
use Pesamate\Exceptions\AuthorizationException;
class Auth{
	public $login;
	public $password;
	public $token;
	private $session;
	public static $instance=null;

	private function setCredentials($login,$password)
	{
		$this->login = trim($login);
		$this->password = trim($password);
		$this->getToken();
		return $this;
	}
	private function setToken($token)
	{
		$this->token = $token;
		return $this;
	}
	public function setTokenSession(TokenSession $session)
	{
		$this->session = $session;
		return $this;
	}
	static function withToken($token){
       return self::getInstance()->setToken($token);
	}
	static function withCredentials($login,$password,$session=null){
		$inst = self::getInstance();
		if(!is_null($session)){
		  $inst->setTokenSession($session);
		}
      return $inst->setCredentials($login,$password);
	}
	static function getInstance(){
        if(is_null(self::$instance)){
	     	$instance = new Auth();
	     }
	     return $instance;
	}
	protected function getToken(){
      
	  	if(!is_null($this->session)){
	      $value = $this->session->get("token");
	      if(!is_null($value)) $this->setToken($value); return;
	  	}
      $client = new Client(['base_uri' => Endpoint::$base_uri]);
      try {
      	$response = $client->post("authenticate",['form_params'=>['login'=>$this->login,'password'=>$this->password]]);
      	
      	$res = json_decode($response->getBody()->getContents());
      	$data = property_exists($res,"details")?$res->details:$res->data;
      	if(!is_null($this->session)){
          $this->session->set("token",$data->token);
      	}
      	
      	$this->setToken($data->token);      	
      } catch (\Exception $e) {
      	throw new AuthorizationException($e->getMessage(), $e->getCode());
      	
      }
	}
}