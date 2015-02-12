<?php
Class Category{
	
	public $sql,$resource,$result;

	function getCatById($id){
		global $dbDatabase;
		$this->sql="SELECT * from categories WHERE id='".$id."'";
		return $this->resource = $dbDatabase->getRow($this->sql);
	}

	
	function databaseByCategory($cat){
		global $dbDatabase;
		$this->sql = "SELECT * from `searchforms` where id in (SELECT database_id from `searchform_category` WHERE category_id='".$cat."') and is_active = '1' order by db_name ";
		$result	= $dbDatabase->run_query($this->sql);
		return $result=$dbDatabase->getAll($result);
	}

	function getSearchedForms($searchstring){
		$searchstr = mysql_real_escape_string($searchstring);
		global $dbDatabase;
		//$this->sql = "SELECT * from `searchforms` where is_active = '1' and ((db_name like '%".$searchstr."%' or db_name = '".$searchstr."') or (db_title like '%".$searchstr."%' or db_title = '".$searchstr."') or (db_description like '%".$searchstr."%' or db_description = '".$searchstr."') or (db_geographic like '%".$searchstr."%' or db_geographic = '".$searchstr."') or (db_misc like '%".$searchstr."%' or db_misc = '".$searchstr."') or (db_periodicity like '%".$searchstr."%' or db_periodicity = '".$searchstr."') or (db_dataseries like '%".$searchstr."%' or db_dataseries = '".$searchstr."') or (db_datasource like '%".$searchstr."%' or db_datasource = '".$searchstr."') or (db_source like '%".$searchstr."%' or db_source = '".$searchstr."'))";
		
		global $db;
		$sql			=	"select * from common_forms where display_dbname='".$_SESSION['databaseToBeUse']."' and is_display = '1' ";
		$commonformsResult	=	$db->run_query($sql, $db->conn);
		$commonIds = '';
		$db_array = array();
		$i = 0;
		if(mysql_num_rows($commonformsResult)>0) {
			while($commonformsDetail = mysql_fetch_assoc($commonformsResult)) {
				$commonIds .=  $commonformsDetail['form_id'].",";
			}
			$icommonIdsds = substr($commonIds, 0, -1);
		    if($icommonIdsds!=''){

				global $admin;
				$siteMainDBDetailUSA = $admin->getMainDbDetail('rand_usa');
				$dbDatabaseUSA = new db(DATABASE_HOST, $siteMainDBDetailUSA['databaseusername'], $siteMainDBDetailUSA['databasepassword'], 'rand_usa');

				$sql	= "select * from searchform_tags where trim(tags) like '%".$searchstring."%' and database_id in (".$icommonIdsds.")";
				$resultTag = $dbDatabaseUSA->run_query($sql, $dbDatabase->conn);
				$idscmm = '';
				if(mysql_num_rows($resultTag)>0){
					while($tagDet = mysql_fetch_assoc($resultTag)){
						$idscmm .= $tagDet['database_id'].",";
					}
					$idscmm = substr($idscmm, 0, -1);
				}

				$wherec = " and ( ";
				$wherec .= " ( db_name like '%".$searchstr."%' or db_name = '".$searchstr."') or (db_title like '%".$searchstr."%' or db_title = '".$searchstr."') or (db_datasource like '%".$searchstr."%' or db_datasource = '".$searchstr."') ";

				if($idscmm!=''){
					$wherec .= " or id in (".$idscmm.") ";
				}

				$wherec .= " )";

				$sqlc = "SELECT * from `searchforms` where is_active = '1' ".$wherec;
				$resultUSA	= $dbDatabaseUSA->run_query($sqlc, $dbDatabaseUSA->conn);
				if(mysql_num_rows($resultUSA)>0){
					while($rowUsa = mysql_fetch_assoc($resultUSA)){
						$db_array[$i] = $rowUsa;
						$db_array[$i]['db_select']		= 'rand_usa';
						$db_array[$i]['form_id_us']		= $rowUsa['id'];
						$db_array[$i]['share']			= 'shared';
						$i++;
					}
				}
			}

		}


		$sql	= "select * from searchform_tags where trim(tags) like '%".$searchstring."%'";
		$resultTag = $dbDatabase->run_query($sql, $dbDatabase->conn);
		$ids = '';
		if(mysql_num_rows($resultTag)>0){
			while($tagDet = mysql_fetch_assoc($resultTag)){
				$ids .= $tagDet['database_id'].",";
			}
			$ids = substr($ids, 0, -1);
		}

		$where = " and ( ";
		$where .= " ( db_name like '%".$searchstr."%' or db_name = '".$searchstr."') or (db_title like '%".$searchstr."%' or db_title = '".$searchstr."') or (db_datasource like '%".$searchstr."%' or db_datasource = '".$searchstr."') ";

		if($ids!=''){
			$where .= " or id in (".$ids.") ";
		}

		$where .= " )";

		$sql = "SELECT * from `searchforms` where is_active = '1' ".$where;

		$result	= $dbDatabase->run_query($sql, $dbDatabase->conn);
		if(mysql_num_rows($result)>0){
			while($rowUsa = mysql_fetch_assoc($result)){
				$db_array[$i] = $rowUsa;
				$i++;
			}
		}
		return $db_array;
	}

	function showSubCategories($cat){
		global $dbDatabase;
		$this->sql			= "select * from categories where parent_id = '".$cat."' order by trim(category_title)";
		$categoriesResult	= $dbDatabase->run_query($this->sql);
		return $result		=$dbDatabase->getAll($categoriesResult);
	}

	function getCommonFormsUS(){
		global $db;
		$this->sql			=	"select * from common_forms where display_dbname='".$_SESSION['databaseToBeUse']."' and is_display = '1' ";
		$commonformsResult	=	$db->run_query($this->sql);
		return 	$commonformsResult;
	}

	function showAllActiveDatabase($cat){
		
		global $db,$dbDatabase;
		
		$info	=	array();
		$admin = new admin();

		$this->sql			=	"select * from categories where parent_id = '".$cat."' order by trim(category_title)";
		$categoriesResult	=	$dbDatabase->run_query($this->sql);
		$categoryDetail		=	$dbDatabase->getAll($categoriesResult);

		if(!empty($categoryDetail)){

			foreach($categoryDetail as $keymain =>$category) {

				$this->sql		=	"SELECT * from `searchforms` where id IN (SELECT database_id from `searchform_category` WHERE category_id='".$category['id']."' and cat_type = 's') and is_active = '1' order by db_name ";
				$related_res	=	$dbDatabase->run_query($this->sql,$dbDatabase->conn);
				$related_db		=	$dbDatabase->getAll($related_res);	
				
				foreach($related_db as $db_array){
					
					$checkifSearchCateria = $admin->selectAllSearchCriteria($db_array['id']);
					
					if((isset($checkifSearchCateria) && count($checkifSearchCateria) > 0) || (isset($db_array['is_static_form']) && $db_array['is_static_form']=='Y')) {
						
						$db_array['share']						= $db_array['db_name'];
						$info[$category['category_title']]['unshared'][]	= $db_array;
					}					
				}
			}	
			
		} else {

			$this->sql		=	"SELECT * from `searchforms` where id in (SELECT database_id from `searchform_category` WHERE category_id='".$cat."' and cat_type = 'p') and is_active = '1' order by db_name ";
			$related_res	=	$dbDatabase->run_query($this->sql,$dbDatabase->conn);
			$related_db		=	$dbDatabase->getAll($related_res);	
			
			foreach($related_db as $key=>$db_array){
				
				$checkifSearchCateria = $admin->selectAllSearchCriteria($db_array['id']);
				
				if((isset($checkifSearchCateria) && count($checkifSearchCateria) > 0) || (isset($db_array['is_static_form']) && $db_array['is_static_form']=='Y')) {
					
					$db_array['share']	= $db_array['db_name'];
					$info[0]['unshared'][]	= $db_array;
				}
			}
		}

		$this->sql			=	"select * from common_forms where display_dbname='".$_SESSION['databaseToBeUse']."' and is_display = '1' ";
		$commonformsResult	=	$db->run_query($this->sql);
		$commonformsDetail	=	$db->getAll($commonformsResult);

		if(!empty($commonformsDetail)) {

			foreach($commonformsDetail as $keycommon => $commonforms) {
				
				$this->sql			=	"select * from categories where id = '".$commonforms['category_id']."' ";
				$categoryDetailAll	= $dbDatabase->getRow($this->sql);

				if(!empty($categoryDetailAll) && $categoryDetailAll['parent_id'] == $cat) {

					$this->sql		=	"SELECT * from `searchforms` where db_name LIKE '".$commonforms['form_name']."' order by db_name";
					$db_array	= $dbDatabase->getRow($this->sql);
					
					if(!empty($db_array)){
						$db_array['db_select']		= $commonforms['select_dbname'];
						$db_array['form_id_us']		= $commonforms['form_id'];
						$db_array['url']			= $commonforms['url'];
						$db_array['share']			= $commonforms['form_name'];
						$db_array['is_static_form']	= $commonforms['is_static_form'];
						$info[$categoryDetailAll['category_title']]['shared'][] =  $db_array;
					} else {
						$db_array['db_select']		= $commonforms['select_dbname'];
						$db_array['form_id_us']		= $commonforms['form_id'];
						$db_array['form_name']		= $commonforms['form_name'];
						$db_array['url']			= $commonforms['url'];
						$db_array['is_static_form']	= $commonforms['is_static_form'];
						$db_array['share']			= $commonforms['form_name'];
						$info[$categoryDetailAll['category_title']]['shared'][] =  $db_array;
					}
				}
			}
		}

		return $info;		
	}
}

?>