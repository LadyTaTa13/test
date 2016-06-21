<?php
function CHECK_RIGHT_NHSO_BY_PID($p){

	$pid=$p["pid"];
	
	$usrName="";
	$psw="";
	//include "../lib_php/core.php";
	$conn=new Connect("webapp");
	$con=$conn->Open();
	
	$sql=" SELECT * FROM int_nhso ORDER BY RAND() LIMIT 1 ";
	$rs=$con->query($sql);
	
	if($rs){
	
		$arr=$rs->fetch_assoc();
		//print_r($arr);
		$usrName=$arr['usrnm'];
		$psw=$arr['pass'];
	
	}
	
	if($usrName==''){
		$conn->ret['c']=1;
		$conn->ret['e']="user error ".$sql;
		return $conn->ret_json($p['config']);
	}

$data='<?xml version="1.0"  encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema"  xmlns:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" >
	<soap:Body>	
		<myns:seacrhByPid xmlns:myns="http://rightsearch.nhso.go.th/">	
		   <pid>'.$pid.'</pid>
		   <userName>'.$usrName.'</userName>
		   <password>'.$psw.'</password>
	  </myns:seacrhByPid>
	</soap:Body>
</soap:Envelope>';


$ws=new WebSocket2($data);
$output=$ws->create2();
$output=text2xml2($output);

$arr=x2a2($output);
//print_r($arr[0]);
$right=substr($arr[0]['maininsclMain'],0,1);
	if($right=='U'){//
	//echo json_encode($arr);
		$conn->ret['c']=0;
		$conn->ret['v']=$arr;
		$conn->ret['e']="ณ วันนี้ ท่านใช้สิทธิ์นี้ได้ แต่จะมีการตรวจสอบสิทธิ์อีกครั้ง ณ วันที่มาตรวจจริง";
	}else{
		$conn->ret['c']=5;
		$conn->ret['e']="ท่านไม่มีสิทธิ์นี้ หรือเป็นไปได้ว่าสิทธิ์ท่านอาจหมดลง";
	}
	//$conn->ret['c']=0;
	//$conn->ret['v']=$arr;
	return $conn->ret_json($p['config']);	
}

class WebSocket2{
	
	var $ch;
	var $p;
	var $send_method;
	var $service_url;
	var $proxy;
	var $proxy_ip;
	var $proxy_port;
	var $proxy_user_pass;
	var $data_send;
	
	public function __construct($data){
		$old_service=0;
		$this->proxy=1;
		$this->proxy_ip='172.17.8.2';
		$this->proxy_port='8080';
		$this->proxy_user_pass='refer:onlinehic0';
		$this->p=$data;
		$this->service_url='http://ucws.nhso.go.th/RightsSearchService/RightsSearchServiceService?xsd=1';
		
		
		$this->ch = curl_init();
	}
	
	
	public function create2(){
		
		$this->data_send=$this->p;
		
		curl_setopt($this->ch, CURLOPT_URL, $this->service_url);
		curl_setopt($this->ch, CURLOPT_HEADER, 0);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		if($this->proxy===1){
			curl_setopt($this->ch, CURLOPT_PROXYPORT, $this->proxy_port);
			curl_setopt($this->ch, CURLOPT_PROXYTYPE, 'HTTP');
			curl_setopt($this->ch, CURLOPT_PROXY, $this->proxy_ip);
			curl_setopt($this->ch, CURLOPT_PROXYUSERPWD, $this->proxy_user_pass);
		}
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 4);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->data_send);
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(                                                                         
			'Content-Type: text/xml',
			'Content-Length: ' . strlen($this->data_send))                                                                      
		);
	
		$output = curl_exec($this->ch);
		curl_close($this->ch);
			
		return $output;
	
		
	}
	

}

function text2xml2($x){
	$dom = new DOMDocument('1.0', 'UTF-8');	
	$dom->loadXML($x);
	return $dom->saveXML();
}
function DisplayXML2($str){
	$dom = new DOMDocument('1.0', 'UTF-8');	
	$dom->loadXML($str);
	header("Content-type: text/xml");
	echo  $dom->saveXML();	
}

function objectToArray2( $object ) {
    if( !is_object( $object ) && !is_array( $object ) ) {
        return $object;
    }
    if( is_object( $object ) ) {
        $object = (array) $object;
    }
    return array_map( 'objectToArray', $object );
}
function x2a2($x){
	$datas=array();
	$dom = new DOMDocument('1.0', 'UTF-8');	
	$dom->loadXML($x);
	$items = $dom->getElementsByTagName('return'); 
	foreach($items as $item) {
			$data = array();
		   
			if($item->childNodes->length) {
				foreach($item->childNodes as $i) {
					$data[$i->nodeName] = $i->nodeValue;
				}
			}
		   
			$datas[] = $data;
    } 
	return $datas;
}

?>