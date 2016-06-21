<?php
class Connect{
	var $host;
	var $username;
	var $password;
	var $db;
	var $conn;
	var $ret=array('c'=>0,'e'=>'','v'=>array());
	var $setName='utf8';
	function __construct($dbName){
		$this->db=$dbName;
		if($dbName=='opr_db'){			
			$this->host='localhost';
			$this->username='root';			
			$this->password='';
			$this->db=$dbName;
		}elseif($dbName=='xxx'){			
			$this->host='localhost';
			$this->username='';			
			$this->password='';
			$this->db=$dbName;
		}
	}
	
	function Open(){
		$this->conn=new mysqli($this->host,$this->username,$this->password,$this->db)or die("can not connect database server  $this->host ");
		if($this->setName!=''){
			$this->conn->query("set names '".$this->setName."'");
		}
		return $this->conn;
	}	
	function ret_json($rsc){
		header('Content-type: application/json; charset=utf-8');
		$msg=$this->ret['e'];
		//echo $msg;
		if($msg==''){
			if(array_key_exists($this->ret['c'],$rsc)){
				$msg=$rsc[$this->ret['c']];
			}
		}
		
		$return=array('_code'=>$this->ret['c'],'_value'=>$this->ret['v'],'_msg'=>$msg);
		return json_encode($return);
	}
}
?>