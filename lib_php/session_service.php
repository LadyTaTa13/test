<?php
	// รายชื่อ service ที่ต้องการ load ข้อมูลจาก session
	
	$cname = array(
	"get_right"=>array(),
	"send_sms"=>array()
	);
	if(array_key_exists($params['cname'],$cname))
	{
		session_start();
		switch ($params['cname'])
		{
			case 'send_sms':
			{
				if(strlen($params['text'])>70)
					$params['text']=substr($params['text'],0,70);
				$par="pid=".$params['pid']."&to=".$params['to']."&from=".$params['from']."&text=".$params['text']."&action=send_sms";
			}break;
			case 'get_right':
			{
				$par="pid=".$_SESSION['pid'];
			}break;
		}
		$usepar=1;
	}
?>