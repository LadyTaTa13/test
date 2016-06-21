<?php
	include "../lib_php/opr.core.php";
	//include "../lib_php/config.php";
$myparam = $_FILES['userfile']; //getting image Here //getting textLabe Here 
$file_nm=explode('.',$myparam['name']);
$pid=$file_nm[0];
$target_path = "../profile_img/"; 
 
if(move_uploaded_file($myparam['tmp_name'], $target_path . basename( $myparam['name']))) { 
     // echo 0;
	  
	  $conn=new Connect("opr_db");
	  $con=$conn->Open();
	  
	  $sql="update mb set profileImage='".$myparam['name']."' where mb_pid='$pid' and mb_status='0'"; //echo $sql;exit();
	  $rs=$con->query($sql);
	  if($rs){
		  echo $myparam['name'];
	  }
	  $con->close();
	  
}
	//return $conn->ret_json($config['rsc']);
?>