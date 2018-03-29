<?php
namespace Pesamate;
use Pesamate\Lib\Request;
use Pesamate\Models\Auth;
class Pesamate extends Request{
   public static $instance=null;

  static function requestBuilder(Auth $auth){
     if(is_null(self::$instance)){
     	$instance = new Pesamate($auth);
     }
     return $instance;
  }

	
}
