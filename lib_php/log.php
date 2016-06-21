<?php
function process_log($method,$params)
{
	if(empty($_SESSION['uid'])){
		$uid=$_SESSION['pid'];
	}else{
		$uid=$_SESSION['uid'];
	}
	$query=json_encode($params);
	$conn=new Connect("opr_db");
	$con=$conn->Open();
	$ip=$_SERVER['REMOTE_ADDR']."|".$_SERVER['HTTP_X_FORWARDED_FOR'];	
	$sql="insert into `log` (ser,action,query,ip,date,uid) values (NULL,'$method','$query','$ip',NOW(),'$uid')";
	$con->query($sql);
	$con->close();
}

function save_log($method,$input,$db){
	$uid=0;
	
	if(!empty($_SESSION['uid'])){
		$uid=$_SESSION['uid'];
	}
	$query=json_encode($input);
	$conn=new Connect($db);
	$con=$conn->Open();
	$ip=Log::get_ip();	
	$sql="insert into newlog (method,params,ip,dtm,uid) values ('$method','$input','$ip',sysdate(),'$uid')";
	$con->query($sql);
	$con->close();
}
?>