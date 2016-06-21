<?php
function list_contact($p){
	
	$conn=new Connect('hospital');
	$con=$conn->Open();
	$i=0;
	$sql="select c.*,a.answer,substring(a.dtm,1,16) as ans_dtm  from contact as c left join answer as a on c.id=a.contact_id and a.cstatus>0 order by id desc;";
	$rs=$con->query($sql);
	if($rs){
		if($rs->num_rows>0){
			while($arr=$rs->fetch_assoc()){
				$id=$arr['id'];
				$nm=$arr['nm'];
				$mobile=$arr['mobile'];
				$email=$arr['email'];
				$detail=$arr['detail'];
				$dtm=Func::ThaiDtm('j M y ',substr($arr['dtm'],0,16));
				$answer=$arr['answer'];
				$ans_dtm=Func::ThaiDtm('j M y ',$arr['ans_dtm']);
								
				$data_row=$rs->num_rows;					
				$arr_data[$i]=array('id'=>$id,'nm'=>$nm,'mobile'=>$mobile,'email'=>$email,'detail'=>$detail,'dtm'=>$dtm,'answer'=>$answer,'ans_dtm'=>$ans_dtm);
				$i++;
			}
			$conn->ret['c']=0;
			$conn->ret['v']=$arr_data;
		}else{
			$conn->ret['c']=0;
			$conn->ret['v']=array();
		}
	}else{
		$conn->ret['c']=1;	
	}
	$con->close();
	return $conn->ret_json($p['config']['rsc']);
	
}?>