<?php
function webservice($p){
	
	$service_config=find_service_config($p['service_nm'],$p['config']['webservice']);
	
	unset($p['config']);
	$p=transformServiceArrayData($p);	
	
    //echo "<pre>";
	//print_r($service_config);
	//echo "</pre>";
	
	$ws=new WebSocket($service_config);
	
	//echo $p;
	$ws->create($p);   
   
	
	if($p['output']=='text' or $p['output']=='service'  or $p['output']=='service_html'){		
		return $ws->res_data;
	}elseif($p['output']=='json' || $p['output']=='pure_json_data'){		
		return $ws->display_json();	
	}elseif($p['output']=='xml'){		
		return $ws->display_xml2();	
	}elseif($p['output']=='jpg'){		
		return $ws->display_jpg();	
	}
	
}

function find_service_config($service,$arr){
	foreach($arr as $webservice){		
		if(in_array($service,$webservice["service_list"])){
			unset($webservice['service_list']);
			return $webservice;			
		}
	}	
}

function transformServiceArrayData($a){
    if(isset($a['params'])){
        $a=$a['params'];
    }
    if(isset($a['service_nm'])){
        $a['method']=$a['service_nm'];
    }
    unset($a['service_nm']);
    return $a;
}


?>