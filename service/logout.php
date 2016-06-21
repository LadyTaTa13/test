<?php
function logout($p){
	session_destroy();
	$conn=new Connect('miswh');
	return $conn->ret_json($p['config']['rsc']);
}
?>