<?php
class db {

	public $conn;
	Public $DBHOST, $DBUSER, $DBPASS, $DBDATABASE;
	
	function db($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_DB){

		$this->DBHOST		=	$DATABASE_HOST;
		$this->DBUSER		=	$DATABASE_USER;
		$this->DBPASS		=	$DATABASE_PASSWORD;
		$this->DBDATABASE	=	$DATABASE_DB;

		$this->conn = mysql_connect( $this->DBHOST, $this->DBUSER, $this->DBPASS, true )or die('Error'.mysql_error());
		mysql_select_db( $this->DBDATABASE ) or die('<b>Error: '.mysql_error().'</b>');
	}

	function count_rows($result){
		return mysql_num_rows ( $result );
	}

	function insert($query, $conn = ''){
		if(is_object($conn)){
			$conn = $conn;
		} else {
			$conn = $this->conn;
		}
		
		try{
		$result = mysql_query ( $query, $conn ) or throw_ex(mysql_error());
		return mysql_insert_id($this->conn);
		}catch(exception $e) {
		  $_SESSION['msgerror'] = $e;
		  return 0;
		}
	}

	function update($query, $conn = ''){
		if(is_object($conn)){
			$conn = $conn;
		} else {
			$conn = $this->conn;
		}

		try{
			$result = mysql_query($query, $conn) or die(MYSQL_ERROR().': '.$query);
			if(mysql_affected_rows($conn)>0){
				return true;
			} else {
				return false;
			}
		}catch(exception $e) {
		  return false;
		}
	}

	function delete($query, $conn = ''){
		
		if(is_object($conn)){
			$conn = $conn;
		} else {
			$conn = $this->conn;
		}

		$result = mysql_query ( $query, $conn ) or die(MYSQL_ERROR().': '.$query);
		if(mysql_affected_rows($conn)>0){
			return true;
		} else {
			return false;
		}
	}

	function run_query($query, $conn = ''){
		
		if(is_object($conn)){
			$conn = $conn;
		} else {
			$conn = $this->conn;
		}

		$result = mysql_query ( $query, $conn ) or die(MYSQL_ERROR().': '.$query);
	
		return $result;
	}

	function getRow($query, $conn = ''){

		if(is_object($conn)){
			$conn = $conn;
		} else {
			$conn = $this->conn;
		}
		$result = mysql_query ( $query, $conn ) or die(MYSQL_ERROR().': '.$query);
		$rowDetail = mysql_fetch_assoc($result);
		return $rowDetail;
	}

	function fetch_row_assoc($result){
		$row = mysql_fetch_assoc ( $result ) or die(MYSQL_ERROR());
		return $row;
	}

	function fetch_row_object($result){
		$object = mysql_fetch_object ( $result ) or die(MYSQL_ERROR());
		return $object;
	}

	function getAll($result){
		$arrayData = array();
		while($row = mysql_fetch_assoc($result)){
			$arrayData[] = $row;
		}
		return $arrayData;
	}

	function getArray($resource,$type='')
	{
		if(is_resource($resource))
		{
			$tmp_arr = array();
			if(mysql_num_rows($resource)>0)
			{
				if($type=='')
				{
					while($row = mysql_fetch_array($resource))
					{
						$tmp_arr[] = $row;
					}
					return $tmp_arr;
				}
				elseif($type=='ASSOC')
				{
					while($row = mysql_fetch_assoc($resource))
					{
						$tmp_arr[] = $row;
					}
					return $tmp_arr;
				}
			}
			else
			{
				return mysql_fetch_assoc($resource);
			}
		}
		else
		{
			echo"Error in Query";
		}
	}
	
	function saveManyGlobalData($table_name=null,$coloum_field_value_str=null,$updated_on_field=null,$updated_on_value=null,$otherfields=null) {
		global $db;
		$sql = "UPDATE `".$table_name."` SET ".$coloum_field_value_str." where `".$updated_on_field."` = '".$updated_on_value."' ".$otherfields." ";
		$return = $db->run_query($sql);
		return true;
	}

	function getUniversalRowAll($table_name=null,$otherfields=null) {
		global $db;
		$sql = "SELECT * FROM `".$table_name."` where 1 ".$otherfields." ";
		return $db->getAll($db->run_query($sql));
	}

	function getUniversalRowColoumAll($table_name=null,$coloum_name_str=null,$otherfields=null) {
		global $db;
		$sql = "SELECT ".$coloum_name_str." FROM `".$table_name."` where 1 ".$otherfields." ";
		return $db->getAll($db->run_query($sql));
	}

	function getUniversalTableData($table_name=null,$coloum_name_str=null,$otherfields=null) {
		global $db;
		$sql = "SELECT  ".$coloum_name_str." FROM `".$table_name."` WHERE 1 ".$otherfields." ";
		return $db->getRow($sql);
	}

	function getUniversalRow($table_name=null,$coloum_name_str=null,$updated_on_field=null,$updated_on_value=null,$otherfields=null) {
		global $db;
		$sql = "SELECT  ".$coloum_name_str." FROM `".$table_name."` WHERE `".$updated_on_field."` = '".$updated_on_value."' ".$otherfields." ";
		return $db->getRow($sql);
	}

	function updateUniversalRow($table_name=null,$coloum_name_str=null,$updated_on_field=null,$updated_on_value=null,$otherfields=null) {
		global $db;
		$sql = "UPDATE `".$table_name."` SET ".$coloum_name_str." WHERE `".$updated_on_field."` = '".$updated_on_value."' ".$otherfields." ";
		return $db->update($sql);
	}

	function deleteUniversalRow($table_name=null,$updated_on_field=null,$updated_on_value=null,$otherfields=null) {
		global $db;
		$sql = "DELETE FROM `".$table_name."` WHERE `".$updated_on_field."` = '".$updated_on_value."' ".$otherfields." ";
		$return = $db->run_query($sql);
		return true;
	}

	function getUniversalFormattedArray($arrayData=null,$keyfield=null) {
		foreach($arrayData as $key => $value){
			$data[$value[$keyfield]][] = $value;
		}
		return $data;
	}

	function getUniversalFormattedArray1D($arrayData=null,$keyfield=null) {
		foreach($arrayData as $key => $value){
			$data[$value[$keyfield]] = $value[$keyfield];
		}
		return $data;
	}

	function getUniversalJoinData($table_name1=null, $table_name2=null, $join_type='JOIN', $onjoinid1=null , $onjoinid2=null, $wherejoinid_str=null, $coloum_name_str='*', $andcondition, $otherfields=null){
		global $db;
		$whereCondition = '';
		if(isset($andcondition) && $andcondition!=''){
			$whereCondition = " and ".$wherejoinid_str." ";
		}
		$sql = "SELECT  ".$coloum_name_str." FROM `".$table_name1."` ".$join_type." `".$table_name2."` ON ".$table_name1.'.'.$onjoinid1." = ".$table_name2.'.'.$onjoinid2." WHERE 1  ".$whereCondition." ".$otherfields." ";
		$result   = $db->run_query($sql);
		return $return = $db->getAll($result);
	}

	function functionInsertUniversalData($tablename, $postedArray){
		global $db;
		$insertStr = $insertData = '';
		if(!empty($postedArray)){
			foreach($postedArray as $coloumname => $value){
				if($value != 'Submit' && $value != 'submit'){
					$insertStr.= "`".$coloumname ."` = '".$value."',";
				}
			}
			$insertData = substr($insertStr,0,-1);
			if(isset($insertData) && $insertData!=''){
				$sql	= "insert into `".$tablename."` SET  ".$insertData." ";
				return $insertResult = $db->insert($sql);
			}
		}
		return false;		
	}

	function functionUniversalAction($tablename=NULL, $action=NULL, $ids=NULL, $status=NULL, $otherfields=NULL){

		global $db;

		switch(trim($action)){
			case 'active':
				$sql    = "update ".$tablename." set block_status='".$status."', is_deleted='0' where id IN (".$ids.")";
				$result	= $db->update($sql);
				if($result){ $_SESSION['msgsuccess'] = "9";}
				break;
			case 'in-active':
				$sql    = "update ".$tablename." set block_status='".$status."', is_deleted='0' where id IN (".$ids.")";
				$result	= $db->update($sql);
				if($result){ $_SESSION['msgsuccess'] = "9";}
				break;
			case 'delete':
				$sql    = "update ".$tablename." set is_deleted='".$status."' where id IN (".$ids.")";
				$result	= $db->update($sql);
				if($result){ $_SESSION['msgsuccess'] = "9";}
				break;
			case 'remove':
				$sql    = "delete from ".$tablename." where id IN (".$ids.")";
				$result	= $db->delete($sql);
				if($result){ $_SESSION['msgsuccess'] = "9";}
				break;
		}
		return $result;
	}

	function paginationData($dataArray=array(), $totalrow='10', $linkpages='5'){
		global $db;
		$obj  = new PS_PaginationArray($dataArray,$totalrow,$linkpages);
		$data = $obj->paginate();
		$returnData['pagiObj']  = $obj;
		$returnData['pagiData'] = $data;
		return $returnData;
	}

	function paginationSqlData($db,$sql=NULL, $totalrow='10', $linkpages='5', $queryString=NULL){
		$obj  = new PS_Pagination($db->conn,$sql,$totalrow,$linkpages,$queryString);
		$res  = $obj->paginate();
		$data = $db->getAll($res);
		$returnData['pagiObj']  = $obj;
		$returnData['pagiData'] = $data;
		return $returnData;
	}

	function truncateTable($tablename=NULL){
		return mysql_query(" TRUNCATE table `".$tablename."` ");
	}

	function dropTable($tablename=NULL){
		return mysql_query(" DROP table `".$tablename."` ");
	}

	function getQuery($tablename=NULL, $coloums='*', $othercondition=NULL){
		$sql = "SELECT ".$coloums." FROM `".$tablename."` ".$othercondition." ";
		return $sql;
	}

	function selectBoxData($tablename=NULL,$optionkey=NULL,$optionvalue=NULL, $othercondition=NULL){
		global $db;$dropdown = array();
		$sql = "SELECT * FROM `".$tablename."` WHERE 1 ".$othercondition." ";
		$data = $db->getAll($db->run_query($sql));
		foreach($data as $coloumname => $value){
			$dropdown[$value[$optionkey]] = $value[$optionvalue];			
		}
		return $dropdown;
	}



}
$db = new db(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
?>