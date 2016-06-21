<?php
function login($params){
	
	$pid=$params['pid'];
	$pwd=md5($params['psw']);	
	
	$conn=new Connect("opr_db");
	$con=$conn->Open();
	$rsx=array();
	$sql="select * from mb where mb_pid='$pid' and mb_pwd='$pwd' and mb_status=0";
	$rs=$con->query($sql);
	
	if($rs){
		if($rs->num_rows>0){
			
			$arr=$rs->fetch_assoc();
			$pid=$_SESSION['pid']=$arr['mb_pid'];		
			$_SESSION['hn']=$arr['mb_hn'];
			$_SESSION['grp']=$arr['mb_grp'];
			$_SESSION['uid']=$arr['mb_pid'];
			$rsx["pid"]=$arr["mb_pid"];
			$rsx["hn"]=$arr["mb_hn"];
			$rsx["ttl_nm"]=$arr["mb_ttl"];
			$rsx["ttl_code"]=$arr["mb_prefix"];
			$rsx["name"]=$arr["mb_fnm"]." ".$arr["mb_lnm"];
			$rsx["fnm"]=$arr["mb_fnm"];
			$rsx["lnm"]=$arr["mb_lnm"];
			$rsx["sex"]=$arr["mb_sex"];
			$rsx["birthdate"]=$arr["mb_dob"];
			$rsx["address"]=$arr["mb_adr"];
			$rsx["moo"]=$arr["mb_moo"];
			$rsx["tumbol"]=$arr["mb_district"];
			$rsx["aumphur"]=$arr["mb_city"];
			$rsx["province"]=$arr["mb_province"];
			$rsx["zipcode"]=$arr["mb_zipcode"];
			$rsx["acode"]=$arr["mb_acode"];
			$rsx["mobile"]=$arr["mb_mobile"];
			$rsx["email"]=$arr["mb_email"];
			$rsx["hmain"]=$arr["mb_hmain"];
			$rsx["fbUserId"]=$arr["fbUserId"];
			$rsx["fbData"]=$arr["fbData"];
			$rsx["profileImage"]=$arr["profileImage"];
			
			$conn->ret['v']=$rsx;
			$conn->ret['e']='login complete.';
		}else{				
			
			$conn->ret['c']=2;
			$conn->ret['e']='User not found!';				
		}
	}else{
		$conn->ret['c']=2;
		$conn->ret['e']='error';	
	}
	$con->close();//
	return $conn->ret_json($params['config']['rsc']);
}
?>