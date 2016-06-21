<?php
session_start();
require_once("lib_php/opr.core.php");
require_once("lib_php/output_format.php");
require_once("lib_php/log.php");
require_once("lib_php/gen_func.php");
require_once("lib_php/config.php");
require_once("lib_php/cross_site.php");

$input = file_get_contents("php://input");
$params= json_decode($input,true);
$method=str_replace("opr_","",$params["method"]);

$arr_key=array_keys($params);
	for($i=0;$i<count($params);$i++){
		$params[$arr_key[$i]]=Func::rep_quote($params[$arr_key[$i]]);
		$params[$arr_key[$i]]=Func::rep_quote2($params[$arr_key[$i]]);
	}	
	
$methods = array(
	"add_sms_task"=>array("log"=>true),
	"reg"=>array(),
	"ck"=>array(),
	"reg_list"=>array(),
	"check_date"=>array(),
	"check_oprdb"=>array("log"=>true),
	"connect_socket"=>array("log"=>true),
	"contact"=>array(),
	"ck_verify"=>array("log"=>true),
	"form_group"=>array(),
	"form_login"=>array(),
	"form_main"=>array(),
	"form_profile"=>array(),
	"form_regist"=>array(),
	"form_reserve"=>array(),
	"form_reserve_data"=>array(),
	"form_reserve_date"=>array(),
	"form_right"=>array(),
	"form_type_check"=>array(),
	"gen_calendar"=>array(),
	"get_data_to_reset_psw"=>array("log"=>true),
	"get_med_history"=>array(),
	"get_smi_fu"=>array("log"=>true),
	"home"=>array(),
	"login"=>array("log"=>true),
	"logout"=>array("log"=>true),
	"menu"=>array(),
	"profile"=>array("log"=>true,"ss"=>true),
	"reg_verify"=>array("log"=>true),
	"reg_form_verify"=>array(),
	"regist"=>array("log"=>true),
	"reset_psw"=>array("log"=>true),
	"reserve"=>array("log"=>true),
	"ck_form_verify"=>array(),
	"search_clinic"=>array(),
	"send_sms"=>array("log"=>true),
	"show_sms_history"=>array(),
	"waiting_list"=>array(),
	"reserve_history"=>array(),
	"history_list"=>array(),
	"history"=>array(),
	"ck_list"=>array(),
	"count_patient"=>array(),
	"insert_hn"=>array("log"=>true),
	"update_symptom"=>array("log"=>true),
	"view_report"=>array("log"=>true)
);
		
if(isset($methods[$method]["log"])){
	if($methods[$method]["log"]){
		save_log($method,$input,'opr_db');
	}
}

if(isset($methods[$method]["ss"])){
	if(isset($methods[$method]["ss_nm"])){
		if($methods[$method]["ss"]){
			if(!in_array($_SESSION[$methods[$method]["ss_nm"]],$methods[$method]["ss_acp"])){
				$conn=new Connect('opr_db');
				$conn->ret['c']=1000;
				$conn->ret['e']=print_r($_SESSION,true);
				
				echo $conn->ret_json($config['rsc']);
				exit();
			}
		}
	}else{
		if($methods[$method]["ss"]){
			if($_SESSION['uid']==''){
				$conn=new Connect('webapp');
				$conn->ret['c']=1000;
				
				echo $conn->ret_json($config['rsc']);
				exit();
			}
		}
	}
}

if($params['output']=='html' or $params['output']=='report'){
	$prefix = "html/";
}else if($params['output']=='json'||$params['output']=='xml'){
	$prefix = "service/";
}

header("Expires: Fri,29 Dec 2006 00:00:00 GMT");

//echo $prefix.$method.".php";
include_once($prefix.$method.".php");
$params["config"]=$config;
echo  call_user_func($method, $params);	
?>