<?php
function add_member($params){
	
        $pid = $params['pid'];
        $hn = $params['hn'];
        $prefix = $params['prefix'];
        $fname = $params['fname'];
        $lname = $params['lname'];
        $sex = $params['sex'];
        $bdate = $params['bdate'];
        $address = $params['address'];
        $moo = $params['moo'];
        $district = $params['district'];
        $city = $params['city'];
        $province = $params['province'];
        $zipcode = $params['zipcode'];
        $tel = $params['tel'];
        $mobile = $params['mobile'];
        $email = $params['email'];
        $pass = md5($params['psw']);
        
        
	$conn=new Connect("opr_db");
	$con=$conn->Open();
	
	$sql="insert 
              into  mb(mb_pid,mb_hn,mb_prefix,mb_fnm,mb_lnm,mb_sex,mb_dob,mb_adr,mb_moo,mb_district,mb_city,mb_province,mb_zipcode,mb_tel,mb_mobile,mb_email,mb_pwd) 
              values('$pid','$hn','$prefix','$fname','$lname','$sex','$bdate','$address','$moo','$district','$city','$province','$zipcode','$tel','$mobile','$email','$pass')";
	
        $rs=$con->query($sql);
	
	if(!$rs){
		$conn->ret['c']=2;
		$conn->ret['e']='error';	
	}
	$con->close();//
	return $conn->ret_json($params['config']['rsc']);
}
?>