<?php
namespace Pesamate\Interfaces;

interface  Notifier{
  
  public function email():array;
  public function sms():array;
  public function telegram():array;
  public function facebook():array;

}