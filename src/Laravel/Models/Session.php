<?php
namespace Pesamate\Laravel\Models;
use Pesamate\Interfaces\TokenSession;
class Session implements TokenSession{
    public function set($key,$value){
      return file_put_contents(storage_path("app/$key"), json_encode(["value"=>$value,"time"=>time()]));
    }
    public function get($key){
      if (file_exists((storage_path("app/$key")))){
      	$data = json_decode(file_get_contents(storage_path("app/$key")));
      	return $data->value;
      }
      return null;
    }
}