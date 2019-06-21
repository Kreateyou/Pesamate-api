<?php
namespace Pesamate\Models;

class CallbackInfo{
	public $urls = [];
	public $overideServer=false;
	public $accepts = "post";
    public $custom_data=[];
    public $error_url="";
	public function __construct($urls,$overideServer,$accepts="post",$cbdata=[],$error_url="")
    {
    	$this->overideServer = $overideServer;
    	$this->urls = $urls;
        $this->error_url = $error_url;
        $this->withCustomData($cbdata);
        $this->accepts = $accepts;
    }
    public function acceptsJson(){
    	$this->accepts = "json";
     return $this;
    }
    public function acceptsGet(){
    	$this->accepts = "get";
    	return $this;
    }
    public function withCustomData(array $data){
        $this->custom_data = $data;
        return $this;
    }
    public function addErrorUrl($url='')
    {
        $this->error_url = $url;
    }
}