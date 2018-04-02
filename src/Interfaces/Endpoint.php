<?php
namespace Pesamate\Interfaces;

use Pesamate\Lib\Request;
use Exception;
use GuzzleHttp\Client;
abstract class Endpoint{
	private $request;
	protected $client;
	public static $base_uri = "https://www.pesamate.com/api/";
	// public static $base_uri = "http://localhost:8000/api/";
	public function __construct(Request $request)
	{
		$this->request = $request;
		$this->client = new Client([
			      'base_uri' => self::$base_uri,
		          'headers' => [ 'Content-Type' => 'application/json','Authorization'=>'Bearer '.$this->request->auth->token]
		          ]);
		return $this->execute();
	}
	public abstract function getRoute();
	public abstract function isBackgroundEnabled();
	protected function execute()
	{
		

		try {

			$params = get_object_vars($this->request);
			unset($params['auth']);
			unset($params['errorCallback']);
			unset($params['successCallback']);
			if($this->request->notifier){
				print_r($this->request->notifier->email());
				$params['notification']['email'] = $this->request->notifier->email();
				$params['notification']['sms'] = $this->request->notifier->sms();
				$params['notification']['telegram'] = $this->request->notifier->telegram();
			}
			unset($params['notifier']);
           $params = $this->_clean($params);
           
		   $data = ['body' => json_encode($params)]; 
		  
		   $response = $this->client->post($this->getRoute(),$data); 
           
		   if($this->request->successCallback){
			return call_user_func_array($this->request->successCallback, [$response->getBody()->getContents()]);
		   }else{
		   	return $response;
		   }	
			
		}catch (\Guzzle\Http\Exception\ClientErrorResponseException $e) {

            // $req = $e->getRequest();
            // $resp =$e->getResponse();
            // displayTest($req,$resp);
            return $this->handleError($e);
        }
        catch (\GuzzleHttp\Exception\ServerException $e) {
             return $this->handleError($e);
        }
        catch (\Guzzle\Http\Exception\BadResponseException $e) {
            return $this->handleError($e);
        }catch(\GuzzleHttp\Exception\ClientException $e){
            return $this->handleError($e);
        }
        catch (\Exception $e) {
		  return $this->handleError($e);
		}
        
    
	}
	/**
	* Exclude empty params 
	**/
	protected function _clean($params)
	{
		
		$data_ = array_filter($params);
		
		if(count($data_)==1){
			$x = array_values($data_);		
			return $x[0];
		}elseif (count($data_)>1) {

			return $data_;
		}
		//throw new Exception("Error Processing Request Empty Params", 1);
		
	}
	protected function handleError($e)
	{
		
      
        if(!method_exists($e, "getResponse")){
		
			$this->processErrors($e->getMessage(),$e->getCode());
			
		}elseif($e->getResponse()->getStatusCode()==404){
			$this->processErrors($this->getRoute()." Endpoint not Found", 404);
			
			
		}else{
			$json = json_decode($e->getResponse()->getBody()->getContents());
			$this->processErrors($json->message, $e->getResponse()->getStatusCode());
			
		}


		
	}
	public function processErrors($message,$code)
	{
		if($this->request->errorCallback){
			call_user_func_array($this->request->errorCallback, [new Exception($message,$code)]);
		}else{
           throw new Exception($message,$code);
           
		}
	}
}
