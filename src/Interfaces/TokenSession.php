<?php
namespace Pesamate\Interfaces;

interface  TokenSession{
  
  public function set($key,$value);
  public function get($key); 

}