<?php

session_start();
	if(empty($_SESSION['uid']) or empty($_SESSION['grpid'])){
		header('location: http://sddn.med.cmu.ac.th');	
	}
	
	$my_data=$_SERVER['QUERY_STRING'];
	unset($_SESSION['grpnm']);
	unset($_SESSION['unm']);
	unset($_SESSION['ip']);
	
	include_once "cross_cer.php";
	$data=arr2kval($_SESSION);
	
	$arr_url=explode('?',substr($my_data,4));
	
	$action=$arr_url[0];
	if(isset($arr_url[1])){ 
		if($arr_url[1]!=''){
			$my_data= $arr_url[1];
			$data=$data.'&'.$my_data;
		}
	}
	
	$chk=cross_cer($data);
	
	$data=$data.'&s='.$chk;
	$method='rc';	
	
	header("location: $action"."?".$data);
?>