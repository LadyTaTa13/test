<?php
$config=array(
	"rsc"=>array(
				0=>'success',
				1=>'can not query(select)',
				2=>'can not query(insert)',
				3=>'can not query(update)',
				4=>'can not query(delete)',
				5=>'no record',
				999=>'send email fail.',
				1000=>'session expire please login again.'),		
	"webservice"=>array(
		array(
			"service_url"=>"172.17.8.231/ws_center/main.php",
			"send_method"=>"post",
			"service_list"=>array("CHECK_RIGHT_OFFICIAL_BY_PID","CHECK_RIGHT_OFFICIAL1_BY_PID","CHECK_RIGHT_SSN_BY_PID","CHECK_RIGHT_UC_BY_PID","SEND_SMS")
		)
	),
	"opr_status"=>array("0"=>"ยกเลิกการจองตรวจแล้ว","1"=>"รอเวชระเบียนตรวจสอบ","2"=>"รอหน่วยคัดกรองตรวจสอบ","3"=>"ให้มาตรวจได้ตามวันที่กำหนดให้","9"=>"ให้มาตรวจได้ตามวันที่กำหนดให้")
);