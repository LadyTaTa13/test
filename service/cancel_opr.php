<?php
function cancel_opr($p){	
	$pid=$p['pid'];
	$id=$p['id'];	
	

	$conn=new Connect("opr_db");
	$con=$conn->Open();
		
	$sql="UPDATE data SET data_status='0' WHERE data_id=$id and data_pid='$pid' and data_status<3";

	$rs=$con->query($sql);	
	
	if(!$rs){
		$conn->ret['c']=1;		
	}
	$con->close();
	return $conn->ret_json($p['config']['rsc']);
}
?>