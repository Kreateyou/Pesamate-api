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
	}
	public function setTokenSession(TokenSession $session)
	{
		$this->session = $session;
		return $this;
	}
	static function withToken($token){
       return self::getInstance()->setToken($token);
	}
	static function withCredentials($login,$password){
      return self::getInstance()->setCredentials($login,$password);
	}
	static function getInstance(){
        if(is_null(self::$instance)){
	     	$instance = new Auth();
	     }
	     return $instance;
	}
	protected function getToken(){
      
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