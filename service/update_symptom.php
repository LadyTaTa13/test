<?php
function update_symptom($p){	
	$pid=$p['pid'];
	$id=$p['id'];	
	$symptom=$p['symptom'];	
	

	$conn=new Connect("opr_db");
	$con=$conn->Open();
		
	$sql="UPDATE data SET data_symptom='$symptom' WHERE data_id=$id and data_status<3";

	$rs=$con->query($sql);	
	$conn->ret['e']='แก้ไขเรียบร้อย';	
	if(!$rs){
		$conn->ret['c']=1;
		$conn->ret['e']='กรุณาลองอีกครั้ง';		
	}
	$con->close();
	return $conn->ret_json($p['config']['rsc']);
}
?>