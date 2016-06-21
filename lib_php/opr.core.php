<?php
class Connect{
	var $host;
	var $username;
	var $password;
	var $db;
	var $conn;
	var $ret=array('c'=>0,'e'=>'','v'=>array());
	var $rsc;
	var $setName='utf8';
	
	function Connect($dbName){
		if($dbName=='opr_db' or $dbName=='hospitalonline'){			
			$this->host='localhost';		
			$this->username='root';
			$this->password='';
			$this->db=$dbName;				
		}elseif($dbName=='miswh'){			
			$this->host='10.0.6.24';		
			$this->username='nxwh2010';
			$this->password='newnxwh2010wintercore';
			$this->setName='';
			$this->db='mis';
		}elseif($dbName=='mis'){
			$this->host='10.0.6.3';
			$this->username='hic2010';
			$this->password='#medhic$';
			$this->setName='';
			$this->db=$dbName;			
		}elseif($dbName=='webapp'){
			$this->host='10.0.6.3';
			$this->username='newmis2';
			$this->password='new^mis^2012';
			$this->db=$dbName;			
		}elseif($dbName=='store_proc'){			
			$this->host='10.0.6.24';		
			$this->username='nxwh';			
			$this->password='nxwh2007';
			$this->db=$dbName;				
		}
	}
	
	function Open(){
		$this->conn=new mysqli($this->host,$this->username,$this->password,$this->db,3307)or die("can not connect database server  $this->host ");
		if($this->setName!=''){
			$this->conn->query("set names '".$this->setName."'");
		}
		return $this->conn;
	}	
	function ret_json($rsc){
		header('Content-type: application/json; charset=utf-8');
		$this->rsc=$rsc;
		$msg=$this->ret['e'];
//		echo $msg;
		if($msg==''){
			if(array_key_exists($this->ret['c'],$this->rsc)){
				$msg=$this->rsc[$this->ret['c']];
			}
		}
		
		$return=array('_code'=>$this->ret['c'],'_value'=>$this->ret['v'],'_msg'=>$msg);
		
		return json_encode($return);
	}
	function Open_($setName){
		$this->connection=mysql_connect($this->host,$this->username,$this->password) or die("can not connect database server  $this->host ");
		mysql_select_db($this->db) or die("can not connect $this->db");
		
		if($setName!=''){
			mysql_query("set names '$setName'",$this->connection);
		}		
	}
	function IClose()
	{
		mysqli_close($this->conn);
	}
	/*function Close(){
		mysql_close($this->connection);
	}*/
	function ExecuteNonQuery($sqlcmd)
	{
		//execute insert,update,delete only
		if( $rslt = $this->conn->query($sqlcmd) )
		{
			$this->rs = $rslt;
			return $rslt;
		}
	}
	
	function Query($sqlcmd)
	{
		$c = $this->conn;
		if( $rslt = $c->query($sqlcmd) )
		{
			if($rslt->num_rows>0){
				$this->rs = $rslt;				
				return $this->GetResult();
			}else{
				return 0;
			}
		}
	//	else
	//	{	
	//		print mysqli_error($c);
	//	}
		return NULL;
	}
	
	// Returns an array of array that corresponds to the fetched row, using the field names as keys of element in each row.
	function GetResult()
	{
		$rslt = $this->rs;						
		$rtab = array();
		if($rslt)
		{
			if($this->conv_f == "")	//not convert
			{
				while( $rw = $rslt->fetch_array() )
				{
					$rtab[] = $rw;
					//array_push($rtab,$rw);
				}					
				$rslt->close();
			}
			else
			{
				$j = mysqli_field_count($this->conn);
				//get field information				
				$fldNms = array();			
				while( $finfo = $rslt->fetch_field() )
				{
					$fldNms[] = $finfo->name;
					//array_push($fldNms,$finfo->name);
				}				
				while( $rw = $rslt->fetch_array() )
				{
					for($i=0; $i<$j; $i++)
					{
						$rw[$fldNms[$i]] = iconv($this->conv_f, $this->conv_t, $rw[$fldNms[$i]]);
					}
					$rtab[]=$rw;					
					//array_push($rtab,$rw);	
				}
				$rslt->close();
			}
		}	
		return $rtab;
	}
	function Query2($sqlcmd)
	{
		$c = $this->conn;
		if( $rslt = $c->query($sqlcmd) )
		{
			$this->rs = $rslt;				
			return $this->GetResult2();
		} 
	//	else
	//	{	
	//		print mysqli_error($c);
	//	}
		return null;
	}
	
	// Returns a NxTable object.
	function GetResult2()
	{
		$rslt = $this->rs;
		if($rslt)
		{			
			$fldinfo= $rslt->fetch_fields();	//get field info
			$mytab 	= new NxTable($fldinfo);
			
			$j = $rslt->field_count;
			
			$toIntArray = array(1=>1, 2=>1, 3=>1, 8=>1, 9=>1);
			$toDoubleArray = array(0=>1, 4=>1, 5=>1, 246=>1);		
			
			if($this->conv_f == "")	//not convert
			{
				while( $rw = $rslt->fetch_row() )
				{				
					$fldType = 0;
					$i = 0;
					foreach($fldinfo as $val)
					{
						$fldType = $val->type;
						if( array_key_exists($val->type, $toIntArray) )
						{
							$rw[$i] = (int)$rw[$i];
						}
						else if( array_key_exists($val->type, $toDoubleArray) )
						{
							$rw[$i] = (double)$rw[$i];
						}							 
						$i++;
					}				  
					$mytab->rows[] = $rw;				  
				}
			}						
			else
			{		
				while( $rw = $rslt->fetch_row() )
				{				
					$fldType=0;
					$i=0;
					foreach($fldinfo as $val)
					{
						$fldType = $val->type;
						if( array_key_exists($val->type, $toIntArray) )
						{
							$rw[$i] = (int)$rw[$i];
						}
						else if( array_key_exists($val->type, $toDoubleArray) )
						{
							$rw[$i] = (double)$rw[$i];
						}
						else
						{
							$rw[$i] = iconv($this->conv_f, $this->conv_t, $rw[$i]);
						}
						$i++;
					}				  
					$mytab->rows[] = $rw;
				}			
			}
			$rslt->close();
		 
			return $mytab;
	     }
		return null;
	}
}
class NxTable
{
	public $cols = array();
	public $rows = array();
	private $orders = array();
	private $fieldCount = 0;
	
	function NxTable($fldinfo)
	{
		$i = 0;
		if($fldinfo != null)
		{
			foreach($fldinfo as $val)
			{						 
				$this->cols[$val->name] = $val->type;
				$this->orders[$val->name] = $i;
				$i++;
			}				  
		}
		$this->fieldCount = $i;
	}
	function F($fldName)		//field order
	{		
		return $this->orders[$fldName];
	}
	
	function V($rowid, $fld)
	{
		switch(gettype($fld))
		{
			case "string" : //field name
			{
				$fo = $this->orders[$fld];
				if($fo != null)
				{
					$row = $this->rows[$rowid];
					return $row[$fo];
				}
			} 
			case "integer" :
			{		
				$row = $this->rows[$rowid];
				return $row[$fld];
			} 	 
		}
		return null;
	}
	
	function reverse_rows()
	{
		$this->rows = array_reverse($this->rows); // reverse with unpreserv the keys
	}
	
	function count_rows()
	{
		return count($this->rows);
	}
	
	function getAssociativeArray()
	{
		$asarr = array();
		$c_names = array_keys($this->cols);
		$cnt = count($this->rows);
		for($r=0; $r<$cnt; $r++)
		{
			$row = $this->rows[$r];
			$i=0;
			$arr = array();
			foreach($c_names as $name)
			{
				$arr[$name] = $row[$i];
				$i++;
			}
			$asarr[$r] = $arr;
		}
		return $asarr;
	}
	
	function CreateAssocArray($rowid, $jmps)
	{
	   //convert simple array to assoc array
	   if($jmps == null)	//no mapping found
	   {
			$myarr = array();
			$c_names = array_keys($this->cols);
			$row = $this->rows[$rowid];
			$i=0;
			foreach($c_names as $name)
			{
				$myarr[$name] = $row[$i];
				$i++;
			}		  
			return $myarr;
	  }
	  else  if($jmps["m"] != null)
	  {
			$myarr= array();
			$maps = $jmps["m"];
			$pairs= explode(",", $maps);
			$j = count($pairs);
			$row = $this->rows[$rowid];
			 
			for($i=0; $i<$j; $i++)
			{
				$kms = explode("-", $pairs[$i]);
				
				$fo = $this->orders[$kms[1]];	
				
				if($fo != null)
				{
					$myarr[$kms[0]] = $row[$fo];
				}
				else
				{
					$myarr[$kms[0]] = null;
				}
			}
			
			return $myarr;
		}
		else
		{
			return null;
		}  
	}
	
	function CreateObject($rowid, $jmps)
	{
		//jmps= jmpObject
		$class_name = $jmps["c"];//class name
		$row = $this->rows[$rowid]; // 
		
		if($class_name != null)
		{
			$obj  = new $class_name;	//create predefined object
			$maps = $jmps["m"];		//map //parse map
			$pairs= explode(",", $maps);
			$j = count($pairs);
			
			for($i=0; $i<$j; $i++)
			{
				//parse key map
				$kms = explode("-",$pairs[$i]);	
				$prop_n = $kms[0];
				$fo = $this->orders[$kms[1]];
				
				if($fo != null)
				{
					$obj->$prop_n = $row[$fo];
				}	
			}
			return $obj;
		}
		return null;
	}
	
	static function  CreateJmp($class_name, $jmp)
	{	
		return array("c"=>$class_name, "m"=>$jmp);
	}	
}

//session class
class NxSS
{	
    public $nxssid;
	public $nxusr;
	
	function NxSS($ssid, $usr)
	{
		$this->nxssid = $ssid;
		$this->nxusr = $usr;
	}
	
	function SetToCurrentSession()
	{
		$_SESSION["ssid"] = $this->nxssid;	//session
		$nxusr = $this->nxusr;
		$_SESSION["uid"]  = $nxusr->id;		//save nx user id into session		
		$_SESSION["unm"]  = $nxusr->fnm." ".$nxusr->lnm;		
		$_SESSION["role"] = $nxusr->role;
		$_SESSION["smiID"]= $nxusr->smiID;
		$groups = $nxusr->groups;
		if($groups != null)
		{
			foreach($groups as $group)
			{
				if($group[6] == 0)
				{
					$_SESSION["grpid"] = $group[0];
					$_SESSION["grpnm"] = $group[1];
					break;						
				}
			}
		}
	}
	
	//static function========================
	static function SetCurGrp($grpid)
	{
		$_SESSION["grpid"]=$grpid;		
	}
	static function IsLogOn()
	{
		return array_key_exists("ssid",$_SESSION);
	}
	static function Start()
	{
		session_start();
	}
	static function Destroy()
	{
		session_destroy();
	}
	
	static function GetSessionInfo()
	{
		$sqlconn = new SqlConn("nx");
		$sqlconn->Open();
		$ssid = $_SESSION["ssid"];
	
		if( $sqlconn->Query("call nx.nx_get_ssinfo($ssid)") )
		{
			$rtab = $sqlconn->GetResult();
		}		
		
		$nxsession = null;
		if($rtab != null)
		{
			//if result is not null
			$row = $rtab[0];					
			$ssid= $row[0];	//session id
			$uid = $row[1];
			$fnm = $row[2];
			$lnm = $row[3];					
			$usr = new NxUser($fnm, $lnm, $uid);
			$usr->role = $row[4];
			$nxsession = new NxSS($ssid, $usr);
		}		
		$sqlconn->Close();
		
		return $nxsession;
	}
	
	static function GetSessionInfo2()
	{
		$sqlconn = new SqlConn("nx");
		$sqlconn->Open();
		$ssid = $_SESSION["ssid"];
		$nxtab= $sqlconn->Query2("call nx.nx_get_ssinfo($ssid)");
		$sqlconn->Close();	 
		if($nxtab != null)
		{
			$jmps= NxTable::CreateJmp("NxUser", "id-nxuid,fnm-nxfnm,lnm-nxlnm,role-nxrole");
			$usr = $nxtab->CreateObject(0,$jmp);					
			$row = $nxtab->rows[0];
			$ssid= $row[$nxtab->F("nxssid")];//session id
			//$usr=$nxtab->CreateObject(0,$jmps);
			$usr = $nxtab->CreateAssocArray(0,$jmps);		 
			//echo $myjson->NxEncode2("1",$nxsession->nxusr,"class","NxUsr");				
			$nxsession = new NxSS($ssid,$usr);
			//echo var_dump($nxsession);
			return $nxsession;
		}
		return null;	
	}
}
//==========================================================================

class NxDom
{
	//Nx2007 : NxDom 
	var $root;
	var $dom;
	var $tmpNxCode;
	var $resultDscp;	//result description
	
	function NxDom($nxcode)
	{
		//$d = new DOMDocument("1.0","utf-8");
		$this->dom = new DOMDocument("1.0", "utf-8");
		$d = $this->dom; 
		$this->root =  $d->appendChild($d->createElement("nx"));
		$this->tmpNxCode=$nxcode;
	}
	
	function GetDom()
	{
		return $this->dom;
	}
	function GetRootDoc()
	{
		return $this->root;
	}
	function SetNxResult($nxcode)
	{
		$this->tmpNxCode = $nxcode;
	}
	
	function PrintXml()
	{
		//print all content in to stream 
		header("Expires: Thu, 01 Dec 1994 16:00:00 GMT");
		header("Content-Type: text/xml");
		$d = $this->dom;
		$this->root->setAttribute("code", $this->tmpNxCode); //code 0 = function success!			
		if($this->resultDscp != "")
		{
			$this->root->setAttribute("dscp", $this->resultDscp);
		}			
		print $d->saveXML();			
	}	
	
	function AppendRootChild($nxnode)
	{
		//nxnode interface must implment  'ToXmlNode' method
		$this->root->appendChild($nxnode->ToXmlNode($this->dom));		
	
	}
	
	function GetNxRow()
	{
		return new NxRow($this->dom, $this->root);
	}
}
//==========================================================================

//Nx2007
class NxRow
{
	var $sqlArr;	//sql AssocArray
	var $dom;
	var $xmpDoc;
	var $xmpRoot;
	var $root;
	var $rsltNode;
	
//	var $reply = array();	// for testing
	
	function NxRow($parentDom, $pRoot)	//parent dom
	{
		$this->dom=$parentDom;
		$this->root=$pRoot;
	}
	function CreateElement($eleNm, $fldList)
	{
		$ele = $this->dom->createElement($eleNm);
		$this->SetAtts($ele, $fldList);
		return $ele;
	}
	function SetAtt($xnode, $fldNm)
	{
		$xnode->setAttribute($fldNm, $this->sqlArr[$fldNm]);
	}
	function SetAtts($xnode, $fldList)
	{
		$fldNms = explode(",", $fldList);		
		//print_r($fldNms);
		$j=count($fldNms);
		foreach($fldNms as $fld)
		{ //print_r($this->sqlArr[$fld]);
		//."<br/>".print_r($this->sqlArr[$fld]);
			$xnode->setAttribute($fld, $this->sqlArr[$fld]);
		}		
	}
	function SetRow($assocArr)
	{
		$this->sqlArr = $assocArr;
	}
	function SetXmp($xmp)
	{
		//set xmp map
		$doc= new DOMDocument();					// creates a DOMDocument-Object
		$doc->loadXML($xmp);						// load an XML string (not an XML file)
		$this->xmpDoc = new DOMXPath($doc);		
		$nodelist = $this->xmpDoc->query("/xmp");	// get root node
		$this->xmpRoot = $nodelist->item(0);
	}
	function Transform()
	{ 
		$n = $this->DoTx($this->xmpRoot);//Recursive 
		$this->root->appendChild($n);
	}	
	function DoTx($xmpNode)
	{		
		$n1 = $this->CreateElement($xmpNode->getAttribute("nm"), $xmpNode->getAttribute("atts"));		
		$nodelist = $this->xmpDoc->query("xmp", $xmpNode);
		foreach($nodelist as $node)
		{
		   $rnode = $this->DoTx($node);
		   $n1->appendChild($rnode);		
		}
		return $n1;
	}
	
	function TransformExt1()
	{ 
		$rootXmp = $this->xmpRoot;
		$this->rsltNode = $this->CreateElement($rootXmp->getAttribute("nm"), $rootXmp->getAttribute("atts"));
	}
	
	function TransformEtx2()
	{		
		$rootXmp = $this->xmpRoot;
		$nodelist= $this->xmpDoc->query("xmp", $rootXmp);
		$xmpData = $nodelist->item(0);
		
		if( $xmpData->nodeName != null && (strcmp($xmpData->nodeName, "") != 0) )
		{
			$dataNode = $this->DoTxExt($xmpData);
			$this->rsltNode->appendChild($dataNode);
		}
	}
	
	function DoTxExt($xmpNode)
	{		
		$newNode = $this->CreateElement($xmpNode->getAttribute("nm"), $xmpNode->getAttribute("atts"));		
		$nodelist= $this->xmpDoc->query("xmp", $xmpNode);
		foreach($nodelist as $node)
		{
		   $rnode = $this->DoTx($node);
		   $newNode->appendChild($rnode);		
		}
		return $newNode;
	}
	
	function TransformExt3()
	{ 
		$this->root->appendChild($this->rsltNode);
	}
	
}
//==========================================================================

class OneStop
{
	static function RowPrint($dbPolicy, $sql, $xmp)
	{
		$rtab = SqlConn::GetTable($dbPolicy, $sql);
		
		if(count($rtab) > 0)
		{
			$nxdom = new NxDom(0);		
			$nxrow = $nxdom->GetNxRow();
	
			$nxrow->SetXmp($xmp);
			
			$j = count($rtab);
			for($i=0; $i<$j; $i++)
			{
				$nxrow->SetRow($rtab[$i]);
				$nxrow->Transform();	
			}
			$nxdom->PrintXml();
		}
		else
		{
			$nxdom= new NxDom(100);
			$nxdom->PrintXml();
		}
	}
	
	static function RowPrint2($row, $xmp)
	{
		$nxdom= new NxDom(0);		
		$nxrow= $nxdom->GetNxRow();
		$nxrow->SetXmp($xmp);			
		$nxrow->SetRow($row);
		$nxrow->Transform();	
		$nxdom->PrintXml();
	}
	
	static function RowPrint3($tbl, $xmp)
	{
		$nxdom= new NxDom(0);		
		$nxrow= $nxdom->GetNxRow();
		$nxrow->SetXmp($xmp);			
		$j = count($tbl);
		if($j>0)
		{
			for($i=0; $i<$j; $i++)
			{
				$nxrow->SetRow($tbl[$i]);
				$nxrow->Transform();		
			}	
			$nxdom->PrintXml();
		}
		else
		{
			$nxdom = new NxDom(100);
		 	$nxdom->PrintXml();
		}
	}
	static function RowPrint4($code, $row, $xmp)
	{
		$nxdom= new NxDom($code);
		$nxrow= $nxdom->GetNxRow();
		$nxrow->SetXmp($xmp);
		$nxrow->SetRow($row);
		$nxrow->Transform();
		$nxdom->PrintXml();
	}
	
	static function RowsPrint5($code, $rslt, $rows, $xmp)
	{
		$nxdom= new NxDom($code);
		$nxrow= $nxdom->GetNxRow();
		$nxrow->SetXmp($xmp);
		
		$nxrow->SetRow($rslt);
		$nxrow->TransformExt1();
		
		$rowcnt = count($rows);
		for($i=0; $i<$rowcnt; $i++)
		{		
			$nxrow->SetRow($rows[$i]);
			$nxrow->TransformEtx2();
		}
		
		$nxrow->TransformExt3();
		$nxdom->PrintXml();
	}
}
//==========================================================================

class NxEnv
{
	public $_t;	//type
	public $_n;	//name
	public $_code;	//code
	public $_value;	//value
	
	function NxEnv($envType, $name, $envCode, $var)
	{
		$this->_t = $envType;
		$this->_n = $name;
		$this->_code = $envCode;
		$this->_value = $var;
	}
}
//==========================================================================

//Synapx JSON 
//implement after http://pear.php.net/pepr/pepr-proposal-show.php?id=198 (Services_JSON)
//
class NxJson
{
	function encode($var)
    {
        switch (gettype($var)) {
		case 'boolean' : 
			return $var ? 'true' : 'false';
		case 'NULL' : 
			return 'null';
		case 'integer' : 
			return (int) $var;
		case 'double' : 
		case 'float' : 
			return (float) $var;
		case 'string' : 
			return '"'.$var.'"';
		case 'array' : 
			if( is_array($var) && count($var) && (array_keys($var) !== range(0, sizeof($var) - 1)) ) 
			{
				// treat as a JSON object
				$properties = array_map(array($this, 'name_value'), 
										array_keys($var), 
										array_values($var));
										
				return '{' . join(',', $properties) . '}';
			}
			//else treat it like a regular array
			$elements = array_map(array($this, 'encode'), $var);
			
			return '[' . join(',', $elements) . ']';
			
		case 'object' : 
			$vars = get_object_vars($var);
			
			$properties = array_map(array($this, 'name_value'), 
									array_keys($vars), 
									array_values($vars));
									
			return '{' . join(',', $properties) . '}';
			
		default : 
			return '{"status":"Encode_Err"}';
        }
    }
	
    function name_value($name, $value)
    {
        $encoded_value = $this->encode($value);
		
	//	if(Services_JSON::isError($encoded_value)) {
	//		return $encoded_value;
	//	}

        return $this->encode(strval($name)) . ':' . $encoded_value;
    }
	//------------------------------------------------------------
	
	static function PrintNewEnv($type, $name, $code, $var)
	{
		$nxj = new NxJson();
		$env = new NxEnv($type, $name, $code, $var);
		echo $nxj->encode($env);
	}
	
	static function PrintEnv($code, $var)
	{
		$nxj = new NxJson();
		$env = new NxEnv(gettype($var), get_class($var), $code, $var);
		echo $nxj->encode($env);
	}
	
	static function PrintJson($var)
	{
		$nxj = new NxJson();
		echo $nxj->encode($var);
	}
}
class NxOutput
{
	function output_array($out_typ, $code, $recset)
	{
		$err_msg = "";
		$err_trace = "";
		$arrResult=explode('|',$code);
		if($arrResult[0] != 0){
			//$err_msg = call_user_func("get_errmsg", $code);
			//$err_trace = $err_msg;
			$err_msg=$arrResult[1];
		}else{
			$err_msg="No error.";
		}
			
		$outdat = array();
		
		$outdat["rslt"]["out_type"] = $out_typ;
		$outdat["rslt"]["code"] 	= $code;
		$outdat["rslt"]["err_msg"] 	= $err_msg;
		$outdat["rslt"]["err_trace"]= $err_trace;
		$outdat["rslt"]["is_nxtbl"] = true;		
		$outdat["data"]["recset"] 	= $recset;
		
		return $outdat;
	}
	function output_array2($arr)
	{	
		if($arr[0] == 0){			
			$arr[2]="No error.";
		}
			
		$outdat = array();
		
		$outdat["rslt"]["code"]=$arr[0];
		$outdat["rslt"]["err_trace"]=$arr[1];
		$outdat["rslt"]["err_msg"]=$arr[4]['method'].' '.$arr[2];					
		$outdat["data"]["recset"]=$arr[3];
		$outdat["rslt"]["out_type"]=$arr[4]['output'];
		$outdat["rslt"]["is_nxtbl"]=true;
		//$outdat["data"]["node_lev"]=$arr[4]['node_lev'];
		return $outdat;
	}
	
}

class MoeJSON{
	// MOE JSON Function
	// Support UTF-8 with no re-encode
	// Support New Line with no need to reencode

	/*
		Encode PHP Array to JSON Format String
		return:
			array
	*/
	function encode($arr)
	{
		$str=MoeJSON::digger($arr);
		return $str;
	}
	
	/*
		Normal Decode with no Error Message
		return:
			array if successed
			negative number if failed
	*/
	function decode(&$str)	
	{
		if($str[0]=='{'&&$str[strlen($str)-1]=='}')
		{
			$ss=substr($str,1);
			$arr=MoeJSON::diggy($ss);
		}
		else
			$arr="-4";
		return $arr;
	}
	
	/*
		Decode With with Error Message
		Use: edocode($str,$errmsg) -> error message will be stored in $errmsg
		return:
			array if successed
			negative number if failed
	*/
	function edecode($str,&$errmsg)	
	{
		$arr=MoeJSON::decode($str);
		if(!is_array($arr))
		{
			$pos=strpos($arr,":")+1;
			$code=intval(substr($arr,0,$pos),10);
			switch($code)
			{
				case -1:
					$errmsg="Expected , or } near ".substr($arr,$pos);
					break;
				case -2:
					$errmsg="Except Character found near ".substr($arr,$pos);
					break;
				case -3:
					$errmsg="Blank KEY is not allow near ".substr($arr,$pos);
					break;
				case -4:
					$errmsg="Expected Last '}' WTF!!";
			}
		}
		return $arr;
	}
	
	function digger($arr)
	{
		$temp="{";
		$n=count($arr);
		$k=0;
		foreach($arr as $key => $value)
		{
			$temp.=$key.":";
			if(is_array($value))
				$temp.=digger($value);
			else
				$temp.="\"".$value."\"";
			if($k<$n-1)
				$temp.=",";
			$k++;
		}
		$temp.="}";
		return $temp;
	}
	
	function diggy(&$str)
	{
		$arr=array();
		$n=strlen($str);
		for($i=0;$i<$n;)
		{
			$key="";
			while($str[$i]!=':')
				$key.=$str[$i++];
			if($key=="")
			{
				$str=substr($str,$i);
				return "-3:".$i;
			}
			$i++;
			if($str[$i]=='"')
			{
				$i++;
				$value="";
				while($str[$i]!='"')
					$value.=$str[$i++];
				$arr[$key]=$value;
			}
			else if($str[$i]=='{')
			{
				$str=substr($str,$i+1);
				$arr[$key]=diggy($str);
				$n=strlen($str);
				$i=0;
			}
			else
			{
				$str=substr($str,$i);
				return "-2:".$str;
			}
			$i++;
			if($i<$n)
				if(!($str[$i]==','||$str[$i]=='}'))
				{
					$str=substr($str,$i);
					return "-1:".$i;
				}
				else
					if($str[$i]=='}')
					{
						$str=substr($str,$i);
						return $arr;
					}
			$i++;
		}
	}
}
function RetRslt($arr){
	$arr[6]->close;
	return NxOutput::output_array2($arr);		
}
?>