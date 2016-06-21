<?php 
function cross_cer($ar){	
	$arr=explode('&',$ar);	
	for($i=0;$i<count($arr);$i++){
		$a[$i]=get_key_val($arr[$i]);
	}	
	$str='~';	
	$pos_a=count($a)-1;	
	for($i=$pos_a;$i>=0;$i--){
		$str.=$a[$i].$a[$pos_a];
	}	
	$str.='^';	
	return md5($str);
}
function cross_cer_a($ar){	
	
	$akey=array_keys($ar);
	$exceptype=array('string','integer');
	$str='~';
	$pos_a=count($ar)-1;	
	for($i=$pos_a;$i>=0;$i--){
		
		if($ar[$akey[$i]]!='' and in_array(gettype($ar[$akey[$i]]),$exceptype)){
			$str.=$ar[$akey[$i]].$ar[$akey[$pos_a]];
		}
	}	
	$str.='^';	
	return md5($str);
}
function chk_cer($arr_c){
	$arr=explode('&',$arr_c);
	$num_a=count($arr)-1;
	$new_arr_c='';	
	for($i=0;$i<$num_a;$i++){		
		$new_arr_c.='&'.$arr[$i];
	}
	$new_arr_c=substr($new_arr_c,1);	
	$rs=false;	
	$cer=trim(get_key_val($arr[$num_a]));	
	$chk_cer=trim(cross_cer($new_arr_c));
	if(strcmp($chk_cer,$cer)==0){
		$rs=true;
	}	
	return $rs;
}
function get_key_val($k){
	$arr=explode('=',$k);
	return $arr[1];
}

function get_val_from_key($str_data,$key){
	$arr=explode('&',$str_data);
	for($i=0;$i<count($arr);$i++){
		$a[$i]=explode('=',$arr[$i]);
		if($a[0]==$key){
			return $a[1];
		}
	}	
	return null;
}
function arr2kval($arr){
	$akey=array_keys($arr);
	$exceptype=array('string','integer');
	for($i=0;$i<count($arr);$i++){
		
		if($arr[$akey[$i]]!='' and in_array(gettype($arr[$akey[$i]]),$exceptype)){
			$str.='&'.$akey[$i].'='.$arr[$akey[$i]];
		}
	}
	return substr($str,1);
}
?>