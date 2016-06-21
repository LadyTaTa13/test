<?php
class Func{
	function DayNm($d){
		$nm='';
		switch($d){
			case '0':
			{
				$nm="อาทิตย์";	
			}break;
			case '1':
			{
				$nm="จันทร์";	
			}break;
			case '2':
			{
				$nm="อังคาร";	
			}break;
			case '3':
			{
				$nm="พุธ";	
			}break;
			case '4':
			{
				$nm="พฤหัสบดี";	
			}break;
			case '5':
			{
				$nm="ศุกร์";	
			}break;
			case '6':
			{
				$nm="เสาร์";	
			}break;
		}
		return $nm;	
	}
	function ThaiDtm($format,$date){	
		$year=substr($date,0,4);
		$m=substr($date,5,2);
		$d=substr($date,8,2);
		$Y=$year+543;
		$time=substr($date,11);		
		if(empty($date) or $year=='0000' or $year=='0001'){
			return "-";
		}else{
			switch ($m) {
				case "01" : {
					$F="มกราคม";
					$M="ม.ค.";				
					$n="1";
				}break;
				case "02" : {				
					$F="กุมภาพันธ์";
					$M="ก.พ.";
					$n="2";
				}break;
				case "03" : {				
					$F="มีนาคม";
					$M="มี.ค.";
					$n="3";
				}break;
				case "04" : {
					$F="เมษายน";
					$M="เม.ย.";
					$n="4";
				}break;
				case "05" : {
					$F="พฤษภาคม";
					$M="พ.ค.";
					$n="5";
				}break;
				case "06" : {
					$F="มิถุนายน";
					$M="มิ.ย.";
					$n="6";
				}break;
				case "07" : {
					$F="กรกฎาคม";
					$M="ก.ค.";
					$n="7";
				}break;
				case "08" : {
					$F="สิงหาคม";
					$M="ส.ค.";
					$n="8";
				}break;
				case "09" : {
					$F="กันยายน";
					$M="ก.ย.";
					$n="9";
				}break;
				case "10" : {
					$F="ตุลาคม";
					$M="ต.ค.";
					$n="10";
				}break;
				case "11" : {
					$F="พฤศจิกายน";
					$M="พ.ย.";
					$n="11";
				}break;
				case "12" : {				
					$F="ธันวาคม";
					$M="ธ.ค.";
					$n="12";
				}break;			
			}
			$arrFormat=str_split($format);
			$thaiDate='';
			
			for($i=0;$i<count($arrFormat);$i++){
				switch($arrFormat[$i]){
					case "d":{
						$thaiDate.=$d;
					}break;
					case "j":{
						$j=$d*1;
						$thaiDate.=$j;
					}break;
					case "m":{
						$thaiDate.=$m;
					}break;
					case "M":{
						$thaiDate.=$M;
					}break;
					case "F":{
						$thaiDate.=$F;
					}break;
					case "n":{
						$thaiDate.=$n;
					}break;
					case "Y":{
						$thaiDate.=$Y;
					}break;
					case "y":{
						$y=substr($Y,2);
						$thaiDate.=$y;
					}break;
					default:{
						$thaiDate.=$arrFormat[$i];
					}
				}				
			}
			if($time!=''){
				$thaiDate.=" ".$time;
			}		
			return $thaiDate;
		}
	}
	function chk_pid($id){
		if(strlen($id)==13){
			$count=13;
			$totalID=0;
			for($i=0;$i<12;$i++){
				$arrayID[$i]=substr($id,$i,1);
				$totalID=$totalID+($arrayID[$i]*$count);
				$count--;
			}
			$part=$totalID%11;
			
			if($part==0){
				$bits=1;
			}elseif($part==1){
				$bits=0;
			}else{
				$bits=11-$part;
			}
			if($bits==substr($id,12,1)){
				return true;	
			}else{
				return false;
			}		
		}else{
			return false;	
		}	
	}
	function ChkTime($val){
		$arrTm=explode(':',$val);
		if(count($arrTm)<2){
			if(strlen($val)==4){
				$hr=substr($val,0,2);
				$mn=substr($val,2,2);
				if($hr>23 or $hr<0 or $mn>59 or $mn<0){
					$hr='00';
					$mn='00';
				}
			}else{
				$hr='00';
				$mn='00';
			}
			$tm=$hr.':'.$mn;	
		}else{
			if($arrTm[0]>23 or $arrTm[0]<0 or $arrTm[1]>59 or $arrTm[1]<0){
				$arrTm[0]='00';
				$arrTm[1]='00';
			}
			$tm=$arrTm[0].':'.$arrTm[1];	
		}
		return $tm;
	}	
	
	function CalAge($born){
		list($bYear,$bMonth,$bDay)=explode('-',$born);
		list($year,$month,$day)=explode('-',date("Y-m-d"));
		if($bYear<1970){
			$yearAdjust=1970-$bYear;
			$bYear=1970;
		}else{
			$yearAdjust=0;
		}
		$birthDate=mktime(0,0,0,$bMonth,$bDay,$bYear);
		$date=mktime(0,0,0,$month,$day,$year);
		$age=$date-$birthDate;
		return date('Y',$age)-1970+$yearAdjust;
	}
	function CalDate($born,$date2){
		list($bYear,$bMonth,$bDay)=explode('-',$born);
		list($year,$month,$day)=explode('-',$date2);
		if($bYear<1970){
			$yearAdjust=1970-$bYear;
			$bYear=1970;
		}else{
			$yearAdjust=0;
		}
		$birthDate=mktime(0,0,0,$bMonth,$bDay,$bYear);
		$date=mktime(0,0,0,$month,$day,$year);
		$age=$date-$birthDate;
		return date('Y',$age)-1970+$yearAdjust;
	}
	function CalDay($born,$date2){
		list($bYear,$bMonth,$bDay)=explode('-',$born);
		list($year,$month,$day)=explode('-',$date2);
		if($bYear<1970){
			$yearAdjust=1970-$bYear;
			$bYear=1970;
		}else{
			$yearAdjust=0;
		}		
		$birthDate=mktime(0,0,0,$bMonth,$bDay,$bYear);
		$date=mktime(0,0,0,$month,$day,$year);
		$age=$date-$birthDate;
		if(date('Y',$age)-1970+$yearAdjust<0){
			$result=Func::CalSwapDay($date2,$born);
		}else{
			$result=date('Y',$age)-1970+$yearAdjust."/".date('m',$age)."/".date('d',$age);
		}		
		return $result;
	}
	function CalSwapDay($born,$date2){
		list($bYear,$bMonth,$bDay)=explode('-',$born);
		list($year,$month,$day)=explode('-',$date2);
		if($bYear<1970){
			$yearAdjust=1970-$bYear;
			$bYear=1970;
		}else{
			$yearAdjust=0;
		}		
		$birthDate=mktime(0,0,0,$bMonth,$bDay,$bYear);
		$date=mktime(0,0,0,$month,$day,$year);
		$age=$date-$birthDate;
		$result=date('Y',$age)-1969+$yearAdjust."/".date('m',$age)."/".date('d',$age);		
		return $result;
	}	
	
	
	function GetTumbon($code){		
		$misConn=new Connect('hs');
		$conn=$misConn->Open('utf8');
		$sql="select tam from post where micode='$code'";	
		if($rs=$conn->query($sql)){
		  	if(mysqli_num_rows($rs)>0){
				$arr=$rs->fetch_array();
				return $arr['tam'];
			}
		}
	}
	function GetSex($sex){		
		if($sex==1){
			return "ชาย";
		}elseif($sex==2){
			return "หญิง";
		}
	}
	function ConvSexN2SMI($sex){		
		if($sex==1){
			return "ช";
		}elseif($sex==2){
			return "ญ";
		}else{
			return "";
		}
	}
	function ConvSexKoiThai2N($sex){		
		if($sex=="m"){
			return 1;
		}elseif($sex=="f"){
			return 2;
		}else{
			return 0;
		}
	}
	function GetAumphur($code){		
		$misConn=new Connect('hs');
		$conn=$misConn->Open('utf8');
		$sql="select amp from post where SUBSTRING(micode,-6,4)=$code";	
		if($rs=$conn->query($sql)){
		  	if(mysqli_num_rows($rs)>0){
				$arr=$rs->fetch_array();
				return $arr['amp'];
			}
		}
	}
	function GetCwt($code){		
		$misConn=new Connect('hs');
		$conn=$misConn->Open('utf8');
		$sql="select cwt from post where SUBSTRING(micode,-6,2)=$code";	
		if($rs=$conn->query($sql)){
		  	if(mysqli_num_rows($rs)>0){
				$arr=$rs->fetch_array();
				return $arr['cwt'];
			}
		}
	}	
	
	function AddSpace($num){
		$space="";
		for($i=0;$i<=$num;$i++){
			$space=$space."&nbsp;";
		}
		return $space;
	}
	
	function EaiDobFormat($dob){
		$dobArr=explode('-',$dob);
		$dob=($dobArr[0]*1+543).$dobArr[1].$dobArr[2];
		return $dob;		
	}
	function EaiDateFormat(){		
		$reqDate=date('Y-m-d H:i:s');
		$reqDate=((substr($reqDate,0,4)*1)+543).substr($reqDate,4);
		return $reqDate;
	}
	
	function Hidden($val,$cmp,$replace){
		if($val==$cmp){
			return $replace;
		}else{
			return $val;
		}
	}
	function TONumber($val){		
		$arr=explode(',',$val);
		if(count($arr)>1){
			$valReturn='';
			for($i=0;$i<count($arr);$i++){
				$valReturn=$valReturn.$arr[$i];
			}
			return $valReturn*1;
		}else{
			return $val*1;
		}
	}
	function DateNumber($num){
		if($num<10){
			return "0".$num;
		}else{
			return $num;
		}
	}
	function GetDayInMon($calendarMon,$calendarYear){
	
		$yN=GetYearNext($calendarMon,$calendarYear);
		$mN=GetMonNext($calendarMon);
		$lastday = mktime(0, 0, 0, $mN, 0, $yN);
		return strftime("%d", $lastday);
	}
	function GetYearPrev($m,$y){
		if($m=='01'){
			$y--;
		}
		return $y;
	}
	function GetMonPrev($m){
		if($m=='01'){
			$m='12';
		}else{
			$m=$m*1;
			$m--;
			if($m<10){
				$m='0'.$m;
			}
		}
		return $m;
	}
	function GetYearNext($m,$y){
		if($m=='12'){
			$y++;
		}
		return $y;
	}
	function GetMonNext($m){
		if($m=='12'){
			$m='01';
		}else{
			$m=$m*1;
			$m++;
			if($m<10){
				$m='0'.$m;
			}
		}
		return $m;
	}
	function GetOkDate($y,$m,$d,$numDay){
		return date("Y-m-d", mktime(24*$d, 0, 0, $m, $numDay, $y));
	}
	function DayOfWeek($y,$m,$d){
		$dayOfWeek=getdate(mktime(0,0,0,$m,$d,$y));
		return $dayOfWeek['wday'];
	}
	
	function GetTblFromPage($page){
		switch($page){
			case '0':{
				$tbl='inj_personal';
			}break;	
			case '1':{
				$tbl='er_profile';
			}break;	
			case '2':{
				$tbl='final_profile';
			}break;	
			case '3':{
				$tbl='icu';
			}break;	
			case '4':{
				$tbl='sx_profile';
			}break;	
			case '5':{
				$tbl='or_profile';
			}break;	
		}
		return $tbl;
	}	
	function HideBr($str){
		return str_replace('<br />','',$str);	
	}
	function rep_quote($str){
		return str_replace("'","\'",$str);	
	}
	function rep_quote2($str){
		return str_replace('"','\"',$str);	
	}
	function rep_risk($str){
		return str_replace(array('"',"'"),array('\"',"\'"),nl2br($str));	
	}
	function file_extension($filename){
		$path_info = pathinfo($filename);
		return $path_info['extension'];
	}
	function Img_type($ext){			
		switch($ext){
			case 'jpg':
			{
				return 2;
			}break;
			case 'gif':
			{
				return 1;
			}break;
			case 'png':
			{
				return 3;
			}break;
		}
	}
	
	function logo_path_from_pic_name($img_name){
		if($img_name=='nologo.gif' or $img_name=='default_logo.jpg'){
			return "images/".$img_name;
		}else{
			$pic_floder_m=substr($img_name,4,2);
			$pic_floder_y=substr($img_name,0,4);
			return "img_mb/".$img_name;
		}
	}
	function path_from_pic_name($img_name){
		if($img_name=='nologo.gif' or $img_name=='default_logo.jpg'){
			return "images/".$img_name;
		}else{
			$pic_floder_m=substr($img_name,4,2);
			$pic_floder_y=substr($img_name,0,4);
			return "img_trade/".$pic_floder_y."/".$pic_floder_m."/img/".$img_name;
		}
	}
	function path_from_thumb_name($img_name){
		$pic_floder_m=substr($img_name,4,2);
		$pic_floder_y=substr($img_name,0,4);
		return "img_trade/".$pic_floder_y."/".$pic_floder_m."/thumb/".$img_name;
	}
	function ck_slt($constant,$val){
		if($constant==$val){
			return 'selected="selected"';	
		}	
	}
	function add_zero($num){
		if($num<10){
			return '0'.$num;	
		}else{
			return $num;	
		}
	}
	function year_dir($pic_floder_my){
		return substr($pic_floder_my,0,4);	
	}
	function month_dir($pic_floder_my){
		return substr($pic_floder_my,4,2);	
	}
	function check_word($word){
		// ป้องกันการแทรก html กับ ละเครื่องหมาย ' "
		//$word = htmlspecialchars($word);	

    // ตรวจสอบว่า มีการป้อน url หรือ email มาหรือไม่ ถ้ามีให้ทำ link
	
		//สำหรับเปลี่ยนอักขระที่กำหนด ให้เป็นแทก html ต่างๆ
		$word=eregi_replace('"','\"',$word);
		$word=eregi_replace("'","\'",$word);
		$word=eregi_replace('     ','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$word);
		$word = eregi_replace ( "\[b\]", "<b> " , $word ) ;
		$word = eregi_replace ( "\[/b\]", " </b>" , $word ) ;
		$word = eregi_replace ( "\[i\]", "<i> " , $word ) ;
		$word = eregi_replace ( "\[/i\]", " </i>" , $word ) ;
		$word = eregi_replace ( "\[u\]", "<u> " , $word ) ;
		$word = eregi_replace ( "\[/u\]", " </u>" , $word ) ;
		$word = eregi_replace ( "\[sup\]", "<sup> " , $word ) ;
		$word = eregi_replace ( "\[/sup\]", " </sup>" , $word ) ;
		$word = eregi_replace ( "\[sub\]", "<sub> " , $word ) ;
		$word = eregi_replace ( "\[/sub\]", " </sub>" , $word ) ;
		$word = eregi_replace ( "\[glow\]"," <table style=\"filter:glow(color=pink, strength=3)\"> ", $word ) ;
		$word = eregi_replace ( "\[/glow\]", " </table>" , $word ) ;
		$word = eregi_replace ( "\[shadow\]"," <table style=\"filter:shadow(color=pink, direction=left)\"> ", $word ) ;
		$word = eregi_replace ( "\[/shadow\]", " </table>" , $word ) ;
		$word = eregi_replace ( "\[\-\-\-\]", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" , $word ) ;
		$word = eregi_replace ( "\[color=red\]", "<font color=red> " , $word ) ;
		$word = eregi_replace ( "\[color=green\]", "<font color=green> " , $word ) ;
		$word = eregi_replace ( "\[color=blue\]", "<font color=blue> " , $word ) ;
		$word = eregi_replace ( "\[color=orange\]", "<font color=FF6600> " , $word ) ;
		$word = eregi_replace ( "\[color=pink\]", "<font color=FF00FF> " , $word) ;
		$word = eregi_replace ( "\[color=gray\]", "<font color=999999> " , $word ) ;
		$word = eregi_replace ( "\[/color\]", " </font>" , $word ) ;
	
	
		// ให้ขึ้นบันทัดใหม่ กรณีที่มีการเคาะ Enter
		$word = nl2br($word);
		$word = eregi_replace("(^|[>[:space:]\n])([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])([<[:space:]\n]|$)","<a href=\"\\2://\\3\\4\" target=\"_blank\">\\2://\\3\\4</a>", $word );
	
		$word = eregi_replace("([[:alnum:]]+)@([^[:space:]]*)([[:alnum:]])([<[:space:]\n]|$)","<a href=mailto:\\1@\\2\\3\>\\1@\\2\\3</a>", $word ); 
		return $word;
	}
	function ck_ttl($ttl){
		switch($ttl){
			case '1':
			{
				return 'นาย';	
			}break;
			case '2':
			{
				return 'นาง';	
			}break;
			case '3':
			{
				return 'นางสาว';	
			}break;
			case '4':
			{
				return 'ด.ช.';	
			}break;
			case '5':
			{
				return 'ด.ญ.';	
			}break;
		}
	}
	function Icv($str){
		return iconv('tis-620','utf-8',$str);	
	}
	function Icv2($str){
		return iconv('utf-8','tis-620',$str);	
	}
	function opr_status($status){
		switch($status){
			case 0:
			{
				return "ยกเลิกการจองตรวจแล้ว";
			}break;
			case 1:
			{
				return "รอเวชระเบียนตรวจสอบ";
			}break;	
			case 2:
			{
				return "รอศูนย์คัดกรองตรวจสอบ";
			}break;
			case 3:
			case 9:
			{
				return "ให้มาตรวจได้ตามวันที่กำหนดให้"; 
			}break;	
		}
	}
	
}

class Log{

	/*function get_ip(){

		$ip_address=$_SERVER['REMOTE_ADDR'];	
			
		if ($_SERVER['HTTP_X_FORWARDED_FOR']==NULL){
			$ip_address=$_SERVER['REMOTE_ADDR']; 
		}else{
			$ip_address=$ip_address."|".$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		return $ip_address;
                
	}*/
        
        function get_ip( )
        {
            if (preg_match( "/^([d]{1,3}).([d]{1,3}).([d]{1,3}).([d]{1,3})$/", getenv('HTTP_X_FORWARDED_FOR')))
            {
            
                return getenv('HTTP_X_FORWARDED_FOR');
            }
            return getenv('REMOTE_ADDR');
        }
        
	
	function GetGET(){
		return $_SERVER['QUERY_STRING'];
	}
	
	function GetPOST(){
		return file_get_contents("php://input");
	}	
		
}
?>