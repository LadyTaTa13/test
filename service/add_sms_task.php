<?php
function add_sms_task($params)
{
	$hn=$params['hn'];	
	$date=$params['date'];
	$date_nm=$params['date_nm'];
	$code=$params['code'];
	/*$code=str_replace('  ','',$code);
	$code=str_replace(' ','',$code);*/
	$text="คุณมีนัดวันที่".$date_nm."ที่".$params['text'];
	/*$text=str_replace('  ','',$text);
	$text=str_replace(' $','',$text);
	$text=str_replace('$ ','',$text);
	$text=str_replace('$','',$text);*/
	$conn=new Connect("opr_db");
	$con=$conn->Open();
	
	$sql1="select mb_mobile from mb where mb_hn='$hn'";
	$rs1=$con->query($sql1);
	if($rs1){
		if($rs1->num_rows>0){
			$arr=$rs1->fetch_array();
			$mobile=$arr[0];
			$sql="insert into sms_task (hn,mobile,text,task_dtm,date,clinic) values('$hn','$mobile','$text',sysdate(),'$date','$code')";
			
			$rs=$con->query($sql);
			if($rs){
				
				$conn->ret['e']="การแจ้งเตือนSMS สำเร็จ";
			}else{
				
				$conn->ret['c']=3;
				$conn->ret['e']="ไม่สามารถตั้งค่าการส่งSMSได้";
			}
		}else{
				
			$conn->ret['c']=2;
			$conn->ret['e']="กรุณาระบุเบอร์โทรศัพท์มือถือที่หน้าแก้ไขข้อมูลส่วนตัว";
		}
	}else{
		$conn->ret['c']=1;
		$conn->ret['e']="ไม่สามารถตั้งค่าการส่งSMSได้";
			
	}
	$con->close();
	return $conn->ret_json($params['config']['rsc']);
}
?>