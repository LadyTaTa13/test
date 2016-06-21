<?php
function update_profile($params){
	$pid=$params['pid'];
	$pid_input='';
	if(isset($params['pidInput'])){
		$pid_input=$params['pidInput'];
	}
	if($pid_input!='' and !($pid_input === null)){
		$pid=$pid_input;
	}
	$hn=$params['hn'];
	$prefix=$params['ttl_code'];
	//$ttl_code=$params['ttl_nm'];
	$fnm=$params['fnm'];
	$lnm=$params['lnm'];
	$sex=$params['sex'];
	$dob=$params['birthdate'];
	$adr=$params['address'];
	$moo=$params['moo'];
	$district=$params['tumbol'];
	$city=$params['aumphur'];
	$province=$params['province'];
	$zipcode=$params['zipcode'];
	//$acode=$params['acode'];
	$tel=$params['tel'];
	$mobile=trim($params['mobile']);
	$email=trim($params['email']);
	$pwd=md5($params['psw']);
	$pwd2=md5($params['psw2']);
	$dtm=date("Y-m-d H:i:s");
	
	$fbUserId=0;
	$fbData="";
	
	if(isset($params['fbUserId'])){
		$fbUserId=$params['fbUserId'];
		$fbData=$params['fbData'];
	}
	//$hmain=$params['hmain'];
	//$right=$params['right'];
	//$expdate=$params['expright'];

	$conn=new Connect("opr_db");
	$con=$conn->Open("utf8");
	
	$update_pid="";
	$where=" WHERE mb_pid='$pid' and mb_status='0' ";
	$meurgUser=false;
	if($pid_input!=''){
		$update_pid=" mb_pid='$pid', ";
		$sql2="select * from mb where mb_pid='$pid' and mb_status='0';";
		$rs2=$con->query($sql2);
		if($rs2->num_rows==0){
			$where=" where fbUserId='$fbUserId' and mb_status='0' ";
		}else{
			$meurgUser=true;
		}
	}
	
	
	
		if($params['pwd']==''){
			$sql="UPDATE `mb` SET  $update_pid mb_hn='$hn',mb_sex='$sex',mb_dob='$dob', mb_prefix='$prefix',mb_ttl='$ttl_code',mb_fnm='$fnm',mb_lnm='$lnm',mb_adr='$adr' ,mb_moo='$moo' ,mb_district='$district' ,mb_city='$city' ,mb_province='$province' ,mb_zipcode='$zipcode' ,mb_acode='$acode' ,mb_tel='$tel' ,mb_mobile='$mobile' ,mb_email='$email',mb_hmain='$hmain' ,mb_dtm='$dtm',fbUserId='$fbUserId',fbData='$fbData' $where";
		}else if($pwd==$pwd2){
			$sql="UPDATE `mb` SET  $update_pid mb_hn='$hn',mb_sex='$sex',mb_dob='$dob', mb_prefix='$prefix',mb_ttl='$ttl_code',mb_fnm='$fnm',mb_lnm='$lnm',mb_adr='$adr' ,mb_moo='$moo' ,mb_district='$district' ,mb_city='$city' ,mb_province='$province' ,mb_zipcode='$zipcode' ,mb_acode='$acode' ,mb_tel='$tel' ,mb_mobile='$mobile' ,mb_email='$email' ,mb_pwd='$pwd' ,mb_hmain='$hmain' ,mb_dtm='$dtm' ,fbUserId='$fbUserId',fbData='$fbData' $where";
		}else{
			
			$conn->ret['e']="password ต้องเหมือนกันทั้ง 2 ช่อง";
		
		
			$con->close();
			return $conn->ret_json($params['config']['rsc']);
		}
	
		$rs=$con->query($sql);
	
	if($rs){
		
		if($meurgUser){
			$sql3="update mb set mb_status='1' where fbUserId='$fbUserId' and mb_pid='' limit 1";
			$rs3=$con->query($sql3);
		}
		
		if($hn!='' and $mobile!=''){
				$sql2="update sms_task set mobile='$mobile' where hn='$hn'";
				$rs2=$con->query($sql2);
				if(!$rs2){
					
					$conn->ret['c']=2;
					$conn->ret['e']="error";
				}
		}
		
		$rsx=array();
		$sql4="select * from mb $where ";
		$rs4=$con->query($sql4);
		if($rs4){
			
			$arr=$rs4->fetch_assoc();
			
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
			
			foreach ($rsx as $key => $value) {
			    if (is_null($value)) {
			         $rsx[$key] = "";
			    }
			}
			
			$conn->ret['v']=$rsx;
			$conn->ret['e']='update complete.';
		}else{
			$conn->ret['e']='error select.';
		}
		
	}else{
		$conn->ret['c']=1;
		$conn->ret['e']="error";
	}
	//$conn->ret['e']=$sql;
	$con->close();
	return $conn->ret_json($params['config']['rsc']);
}
?>