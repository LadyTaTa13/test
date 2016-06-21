<?php 
function reserve($params){
	$pid=$_SESSION['pid'];
	$hn=$_SESSION['hn'];
	if(isset($params['pid'])){
		$pid=$params['pid'];
	}
	if(isset($params['hn'])){
		$hn=$params['hn'];
	}
		
	$age=$params['age'];
	$right=$params['right'];
	$status=1;
	$exp_right=$params['exp_right'];
	$room=0;
	$clin=0;
	$type=$params['type'];
	
	$conn=new Connect("opr_db");
	$con=$conn->Open();
	
	$conn2=new Connect("mis");
	$con2=$conn2->Open();
	
	$curday=date('Y-m-d');
	$adv=$params['adv'];
	
	$adv_sec=strtotime($adv);
	$curday_sec=strtotime($curday);
	
	$adate=date('N',$adv_sec);
	$today=date('N',$curday_sec);
		
	$sec_diff=$adv_sec-$curday_sec;
	
	$time=date('H');
	$can=false;
	$msg="กรุณาจองล่วงหน้าอย่างน้อย 2 วันทำการ";
	if($adate>5){
		$msg="กรุณาเลือกวันอื่น (วันเสาร์ อาทิตย์) ไม่สามารถจองได้";
	}else{
		if($sec_diff>518400){
			$can=true;
		}else{
			if($adv>$curday){
				if($time>14 && $today<5){
					$today++;
				}elseif($today>5){
					$today=1;
				}elseif($today==5){
					if($time>14){
						$today=1;
					}
				}
				
				$buffer=$adate-$today;
		
				if($buffer>0){
					
						$can=true;		
				}
			}
		}
	}
	
	$sql3="select date,txt from holiday where date='$adv';";
				
	$rs3=$con2->query($sql3);			
	
	if($rs3){
		if($rs3->num_rows>0){
			
			$arr3=$rs3->fetch_array();				
			
			
			$msg="กรุณาเลือกวันอื่น (".Func::Icv($arr3['txt']).") ไม่สามารถจองได้";
			$can=false;
		}
	}
	
	if(!$can){
		$conn->ret['c']=2;
		$conn->ret['e']=$msg;
		$con->close();
		return $conn->ret_json($params['config']['rsc']);
	}
	
	$real_adv='0001-01-01';
	
	//$symptom=Func::rep_quote($params['symptom']);
	//$note=Func::rep_quote($params['note']);
	
	$symptom=$params['symptom'];
	$note=$params['note'];
	
	
	
	$sql2="select * from data where data_pid='$pid' and data_adv='$adv' and data_status>'0';";
	$rs2=$con->query($sql2);
	if($rs2){
		if($rs2->num_rows>0){
			$conn->ret['c']=1;
			$conn->ret['e']="ไม่สามารถจองลงทะเบียนได้เนื่องจากมีการจองวันนี้อยู่แล้ว";
		}else{
			$sql="INSERT INTO `data` (`data_id` ,`data_pid` ,`data_hn` ,`data_type`,`data_dtm` ,`data_symptom` ,`data_age` ,`data_right` ,`data_status` ,`data_exp_right` ,`data_room` ,`data_clin` ,`data_adv` ,`data_real_adv` ,`data_note` )VALUES ('' ,'$pid','$hn',$type,sysdate(),'$symptom','$age','$right','$status','$exp_right','$room','$clin','$adv','$real_adv','$note');";
			
			$rs=$con->query($sql);
			
			$sql=str_replace(array("\r","\n","\""),array("","",""),$sql);
			
			if(!$rs){
				$conn->ret['c']=1;		
			}else{
				$conn->ret['e']="ลงทะเบียนจองสำเร็จ กรุณารอรับ sms หรือเช็คสถานะได้ที่เมนูประวัติการจองตรวจ";
			}
		}
	}
	
	//$conn->ret['e']="$sec_diff";
	$con->close();
	return $conn->ret_json($params['config']['rsc']);
}
?>