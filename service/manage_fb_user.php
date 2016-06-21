<?php
function manage_fb_user($p){
	$fbUserId=$p['fbUserId'];
	$fbData=json_encode($p['fbData']);
	$fbData=str_replace('"','\"',$fbData);
	$process=true;
	
	$conn=new Connect('opr_db');
	$con=$conn->open();
	$sql="update mb set fbData='$fbData',mb_last_dtm=sysdate() where fbUserId='$fbUserId' and mb_status='0'";
	$rs=$con->query($sql);
	if($rs){
		if($con->affected_rows==0){
			$sql2="insert into mb (mb_dtm,fbUserId,fbData) values(sysdate(),'$fbUserId','$fbData')";
			$rs2=$con->query($sql2);
			if(!$rs2){
				$process=false;
			}
		}
	}else{
		$process=false;
	}
	if($process){
		$rsx=array();
		$sql3="select * from mb where fbUserId='$fbUserId' and mb_status='0';";
		$rs3=$con->query($sql3);
		if($rs3){
			session_start();
			$arr=$rs3->fetch_assoc();
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
			
			foreach ($rsx as $key => $value) {
			    if (is_null($value)) {
			         $rsx[$key] = "";
			    }
			}
			
			$conn->ret['v']=$rsx;
			$conn->ret['e']='login complete.';
		}
	}else{
		$conn->ret['c']=1;
		$conn->ret['e']=$sql.'*****'.$sql2;
	}
	$con->close();
	return $conn->ret_json($p['config']['rsc']);
}
?>