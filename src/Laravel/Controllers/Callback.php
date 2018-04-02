<?php
namespace Pesamate\Laravel\Controllers;
use Illuminate\Http\Request;
/**
* 
*/
class Callback 
{
	
	public function act(Request $request)
	{
		$transaction = $request->getContent();
		$Callback = config("pesamate.onReceivePayment");
		if(isJson($transaction)){
			if(is_callable($Callback)){
				$return = call_user_func_array($Callback,[json_decode($transaction),$request->all()]);
				
			}
		}
		return ['success'=>true,'message'=>null];
	}
}