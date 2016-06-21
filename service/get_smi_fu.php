<?php
function get_smi_fu($p){
	$hn=$p['hn'];	
	if($hn!='' and $hn!=NULL){
	
		$conn=new Connect("miswh");
		$con=$conn->Open();	
		
		$conn2=new Connect("opr_db");
		$con2=$conn2->Open();
		
		$rsx=array();
		$i=0;
		
		$sql="select f.ser,f.date,f.hn,concat(f.name,' ',f.lname) as nm,f.room,f.comefor,f.clin,m.code,m.name as room_nm from fu as f inner join myslu as m on f.room=m.code where hn='$hn' and m.title='clin' order by f.date desc";
		$rs=$con->query($sql);
		if($rs->num_rows>0){	
			while($arr=$rs->fetch_assoc()){			
				
				$room_nm=Func::icv($arr['room_nm']);
				$room_nm=str_replace('  ','',$room_nm);
				$room_nm=str_replace(' $','',$room_nm);
				$room_nm=str_replace('$ ','',$room_nm);
				$room_nm=str_replace('$','',$room_nm);
				$code=$arr['code'];
				$code=str_replace('  ','',$code);
				$code=str_replace(' ','',$code);
				
	
				$arr['nm']= Func::icv($arr['nm']);
				
				$arr['room_nm']= $room_nm;
				$online_channel= 1;
				if($arr['comefor']=='22' or $arr['comefor']=='69'){$online_channel= 1;}
				$arr['online_channel']=$online_channel;
					 
	               
				  	$sql2="select id,status,mobile from sms_task where hn='".$arr['hn']."' and date='".$arr['date']."' and clinic='".$code."' limit 1";
					$rs2=$con2->query($sql2);
					$arr['sms_task_id']=0;
					if($rs2->num_rows>0){
						
						$arr2=$rs2->fetch_assoc();
						$arr['sms_task_id']=$arr2['id'];
						$arr['sms_task']=$arr2['status'];
						$mobile=$arr2['mobile'];
						$arr['mobile']=$arr2['mobile'];
						$arr['sms_task_status_nm']='รอส่ง';
						if($arr2['status']>1){
							$arr['sms_task_status_nm']='ส่งแล้ว';	
							
						}
							
					}else{
						$arr['sms_task']=0;
						$arr['sms_task_status_nm']='ไม่ได้ตั้งการแจ้งเตือน';
					}
					$arr['date_nm']=Func::ThaiDtm('j M y',$arr['date']);
					$rsx[$i]=$arr;
					$i++;
			}
		
		}else{
			$conn->ret['c']=5;
			$conn->ret['e']="ไม่มีข้อมูลการนัด";
		}
		$conn->ret['v']=$rsx;
		$con->close();
		return $conn->ret_json($p['config']['rsc']);
	 }
 }
 ?>