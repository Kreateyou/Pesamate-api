<?php
namespace Pesamate\Lib;
use Pesamate\Interfaces\Notifier;

class Notification implements Notifier{

	public function email():array{
		return [];
	}

    public function sms():array{
       return [];
    }
    public function telegram():array{
		return [];
	}

    public function facebook():array{
       return [];
    }
}