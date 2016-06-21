<?php
function update_no($p){
$conn=new Connect("opr_db");
	$con=$conn->Open();
$i=1;
$sql="select id from rf.member";
$rs=$con->query($sql);
while($arr=$rs->fetch_assoc()){
	$id=$arr['id'];
	echo $sql="update rf.member set no='$i' where id=$id;";
	$con->query($sql);
	$i++;
}
}
?>