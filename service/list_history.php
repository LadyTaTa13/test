<?php
function list_history($p){
	
	$pid=$_SESSION['pid'];
	if(isset($p['pid'])){
		$pid=$p['pid'];
	}
	$conn=new Connect("opr_db");
	$con=$conn->Open();
	$sql = "Select * from data where data_pid='$pid' and data_status>0 order by data_dtm desc";
	$rs = $con->query($sql);
	$rsx=array();
	$i=0;
	if($rs)
	{
		
		if($rs->num_rows>0){
			$opd_arr=array();
			$conn2=new Connect("webapp");
			$con2=$conn2->Open();
			$sql2 = "select trim(opd_id) as opd_id,trim(opd_nm) as opd_nm,trim(phone) as phone,trim(address) as address from opd_data";
			$rs2 = $con2->query($sql2);
			while($arr2=$rs2->fetch_assoc()){
				$opd_arr[$arr2['opd_id']]=$arr2;
			}
			while($arr=$rs->fetch_assoc())
			{
				$rsx[$i]["opr_room"]="-";
				$rsx[$i]["opr_room_address"]="-";
				$rsx[$i]["opr_room_phone"]="-";
				$rsx[$i]["id"]=$arr['data_id'];
				$rsx[$i]["hn"]=$arr['data_hn'];
				$rsx[$i]["pid"]=$arr['data_pid'];
				$rsx[$i]["data_dtm"]=Func::ThaiDtm('j M y ',substr($arr['data_dtm'],0,10));
				$rsx[$i]["target_date"]=Func::ThaiDtm('j M y',$arr['data_adv']);
				$rsx[$i]["real_date"]=Func::ThaiDtm('j M y',$arr['data_real_adv']);
				$rsx[$i]["opr_status"]=$arr['data_status'];
				$rsx[$i]["opr_status_nm"]=$p['config']['opr_status'][$arr['data_status']];
				$rsx[$i]["symptoms"]=$arr['data_symptom'];
				$rsx[$i]["slot_id"]=$arr['slot_id'];
				
				if($arr['data_room']!='0' and $arr['data_room']!='' and $arr['data_room']!=NULL){
					$rsx[$i]["opr_room"]=$opd_array[$arr['data_room']]['opd_nm'];
					if($rsx[$i]["opr_room"]===NULL){
						$rsx[$i]["opr_room"]='not found!';
					}else{
						$rsx[$i]["opr_room_address"]=$opd_array[$arr['data_room']]['address'];
						$rsx[$i]["opr_room_phone"]=$opd_array[$arr['data_room']]['phone'];
					}
				}
				$i++;		
			}	
		}
	}
	$conn->ret['v']=$rsx;
	$con->close();
	return $conn->ret_json($p['config']['rsc']);
}
?>