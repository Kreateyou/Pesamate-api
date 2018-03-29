<?php
namespace Pesamate\Models;

class Order{
	public $ref;
	public $amount;
	public $note;
	public $alias_ref;
	public function __construct($ref,$amount,$note="")
	{
		$this->ref = $ref;
		$this->amount = $amount;
		$this->note = $note;
	}
	public function withAliasRef($ref)
	{
		$this->alias_ref = $ref;
	}
}