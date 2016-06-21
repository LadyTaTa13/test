<?php
//Synapx Enterprise 2006-2007,PlearnSoft
//more info
//parameters
//
function output_format($outdata)
{
	$rslt = $outdata["rslt"];
	$data = $outdata["data"];
	//echo strtolower($rslt["out_type"]);
	if( strcmp(strtolower($rslt["out_type"]), "json") == 0 ){
		output_json($rslt, $data);		
	}elseif( strcmp(strtolower($rslt["out_type"]), "csv") == 0 ){
		output_csv($rslt, $data);
	}elseif( strcmp(strtolower($rslt["out_type"]), "array") == 0 ){
		return $data['recset'];	
	}elseif(strcmp(strtolower($rslt["out_type"]), "xml") == 0){ // xml is default
		output_xml($rslt, $data);
	}else{ //HTML
		return $data['recset'];
	}
}

function RetJSON($err_code,$err_trace,$err_msg,$recset)
{
	echo '{"_t":"array","_n":false,"_code":'.$err_code.',"_value":{"err_msg":"'.$err_msg.'","err_trace":"'.$err_trace.'","recset":"'.$recset.'"}}';
}

function output_json($rslt, $data)
{
	$reply = array();
	
	$reply["err_msg"] = $rslt["err_msg"];
	$reply["err_trace"] = $rslt["err_trace"];
	
	$arr_key = array_keys($data);
	$key_cnt = count($arr_key);
	
	for($i=0; $i<$key_cnt; $i++)
	{
		$key_name = $arr_key[$i];
		$reply[$key_name] = $data[$key_name];
	}
		
	NxJson::PrintEnv($rslt["code"], $reply);
}

function output_csv($rslt, $data)
{
}

function output_xml($rslt, $data)
{
	if( $rslt["is_nxtbl"] ){
		output_xml5($rslt, $data);
	}
	else{
		output_xml4($rslt, $data);	
	}
	/*else{
		output_jml($rslt, $data);
	}*/
}
function output_xml4($rslt, $data)
{
	$row = array();
	
	$row["err_msg"] = $rslt["err_msg"];
	$row["err_trace"] = $rslt["err_trace"];
	
	$arr_key = array_keys($data);
	$key_cnt = count($arr_key);
	
	$xmp  = "<xmp nm='rslt' atts='err_msg,err_trace'>";
	$xmp .= "<xmp nm='data' atts='";
	
	for($i=0; $i<$key_cnt; $i++)
	{
		$key_name = $arr_key[$i];
		$row[$key_name] = $data[$key_name];
		
		if($i == 0)
			$xmp .= "$key_name";
		else
			$xmp .= ",$key_name";
	}
	
	$xmp .= "'/>";
	$xmp .= "</xmp>";

//	For testing	
//	$reply["xmp"] = $xmp;
//	NxJson::PrintEnv($rslt["code"], $reply);
// 	return;
		
	OneStop::RowPrint4($rslt["code"], $row, $xmp);
}

function output_xml5($rslt, $data)
{
//	For testing
//	NxJson::PrintEnv($rslt["code"], $data);
//	NxJson::PrintEnv(0, "\r\n\r\n");
//	return;
	
	$errm = array();
	$rows = array();
	
	$errm["err_msg"] = $rslt["err_msg"];
	$errm["err_trace"] = $rslt["err_trace"];
	
	if( $rslt["code"] == 0)
		$rows = $data["recset"]->getAssociativeArray();
	
//	For testing	
//	NxJson::PrintEnv($rslt["code"], $errm);
//	NxJson::PrintEnv(0, "\r\n\r\n");
//	NxJson::PrintEnv($rslt["code"], $rows); 
//	return;
	
	$arr_cnm = array();
	if( $rslt["code"] == 0)
		$arr_cnm = array_keys($data["recset"]->cols);
	
//	For testing	
//	NxJson::PrintEnv(0, "\r\n\r\n");
//	NxJson::PrintEnv($rslt["code"], $arr_cnm); 
//	return;
	
	$col_cnt = count($arr_cnm);
	
	$xmp  = "<xmp nm='rslt' atts='err_msg,err_trace'>";
	$xmp .= "<xmp nm='data' atts='";
	
	for($i=0; $i<$col_cnt; $i++)
	{
		$col_name = $arr_cnm[$i];
		if($i == 0)
			$xmp .= "$col_name";
		else
			$xmp .= ",$col_name";
	}
	
	$xmp .= "'/>";
	$xmp .= "</xmp>";

//	For testing	
//	NxJson::PrintEnv(0, "\r\n\r\n");
//	NxJson::PrintEnv($rslt["code"], $xmp);
//	NxJson::PrintEnv(0, "\r\n\r\n");
//	return;
	
	OneStop::RowsPrint5($rslt["code"], $errm, $rows, $xmp);
}

?>
