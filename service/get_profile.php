<?php
function get_profile($p){
	$pid=$_SESSION['pid'];

	$conn=new Connect('opr_db');
	$con=$conn->Open();
	$rsx=array();
	$sql4="select * from mb where mb_pid='$pid'";
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
                $rsx["tel"]=$arr["mb_tel"];
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
		
	
	$con->close();
	return $conn->ret_json($p['config']['rsc']);
}
?>