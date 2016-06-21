<?php
class WebSocket{
   
    var $ch;
    var $p;
    var $send_method;
    var $service_url;
    var $proxy;
    var $proxy_ip;
    var $proxy_port;
    var $proxy_user_pass;
    var $data_send;
	var $res_data;
   
    public function __construct($data){
       // print_r($data);
        $this->proxy=0;
        $this->proxy_ip='172.17.8.12';
        $this->proxy_port='8080';
        $this->proxy_user_pass='480703:480703____';
        $this->c=$data;
       
         
       
        $this->service_url=$this->c['service_url'];
        $this->send_method=$this->c['send_method'];
       
       
        unset($this->c['service_url']);
        unset($this->c['send_method']);
       
        if(isset($this->c['proxy_ip'])){
            $this->proxy_ip=$this->c['proxy_ip'];
            $this->proxy=1;
           
            //unset($this->c['proxy_ip']);
        }
        if(isset($this->c['proxy_port'])){
            $this->proxy_port=$this->c['proxy_port'];
           
            //unset($this->c['proxy_port']);
        }
        if(isset($this->c['proxy_user_pass'])){
            $this->proxy_user_pass=$this->c['proxy_user_pass'];
           
            //unset($this->c['proxy_user_pass']);
        }
       
        $this->ch = curl_init();
    }
   
   
   
   
   
     public function create($data){
		
		$this->p=$data;
		
        $this->data_send=json_encode($this->p);
       
        curl_setopt($this->ch, CURLOPT_URL, $this->service_url);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        if($this->proxy===1){
            curl_setopt($this->ch, CURLOPT_PROXYPORT, $this->proxy_port);
            curl_setopt($this->ch, CURLOPT_PROXYTYPE, 'HTTP');
            curl_setopt($this->ch, CURLOPT_PROXY, $this->proxy_ip);
            curl_setopt($this->ch, CURLOPT_PROXYUSERPWD, $this->proxy_user_pass);
        }
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->data_send);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(                                                                        
            'Content-Type: application/json',                                                                              
            'Content-Length: ' . strlen($this->data_send))                                                                     
        );
        
        $this->res_data = curl_exec($this->ch);
        curl_close($this->ch);   
       
    }
   
   function display_xml(){
		
		$dom = new DOMDocument('1.0', 'utf-8');	
		$dom->loadXML($this->res_data);
		header("Content-type: text/xml");
		return  $dom->saveXML();
		
	}
	function display_xml2(){		
		
		header("Content-type: text/xml");
		return  $this->res_data;
		
	}
	function display_jpg(){		
		header("content-type: image/jpeg");
		return $this->res_data;
	}
    function display_json(){		
		header("content-type: application/json");
		return $this->res_data;
	}

}

/*function a2raw($a){
	$key=array_keys($a);
	$raw='';
	for($i=0;$i<count($a);$i++){
		$val=$a[$key[$i]];
		if($key[$i]==''){
			$val=urlencode($a[$key[$i]]);
		}
		$raw.='&'.$key[$i].'='.$val;
	}
	return substr($raw,1);
}*/

function a2raw($a){
	$key=array_keys($a);
	$raw='';
	for($i=0;$i<count($a);$i++){
		$val=$a[$key[$i]];
		if($key[$i]==''){
			$val=urlencode($a[$key[$i]]);
		}
		$fixKey=fixRawKey($key[$i],$arrKey);
		if(!($fixKey===NULL)){
			$raw.='&'.$fixKey.'='.$val;
		}else{
			$raw.='&'.$key[$i].'='.$val;
		}
	}
	return substr($raw,1);
}

function fixRawKey($key,$arrKey){
	for($i=0;$i<count($arrKey);$i++){
		$n=strlen($arrKey[$i]);
		if(substr($key,0,$n)==$arrKey[$i]){
			return $arrKey[$i];
			break;	
		}
	}
	return NULL;
}


function objectToArray( $object ) {
    if( !is_object( $object ) && !is_array( $object ) ) {
        return $object;
    }
    if( is_object( $object ) ) {
        $object = (array) $object;
    }
    return array_map( 'objectToArray', $object );
}
?>