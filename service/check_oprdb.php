<?php 
function check_oprdb($params){
	$uid=$params['pid'];
	
	$conn=new Connect("opr_db");
	$con=$conn->Open();
	
	$sql="select * from mb where mb_pid='$uid' and mb_status=0";
	
	$rs=$con->query($sql);
	$conn->ret['v']=$rs->num_rows;
	
	$con->close();
	return $conn->ret_json($params['config']['rsc']);
}
?>