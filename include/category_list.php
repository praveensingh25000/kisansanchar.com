<?php
/******************************************
* @Created on JAN 27, 2014
* @Package: Rand
* @Developer: Praveen Singh
* @URL : http://kisansanchar.com/
********************************************/

$parent_cat_count = 0;
$tablenamelang    = 'language';

$notInCategory = '';
if(isset($_SESSION['session_user_data']['user_type']) && is_numeric($_SESSION['session_user_data']['user_type'])) {
	$notInCategory = implode(',',array('261','275'));
}
$categoryDetail = $adminObj->listallsubCategoryActCategory($tablename='category', $status='0', $notInCategory);
if(isset($_SESSION['session_user_data']['id'])){
	$categoryDetail    = array();
	$session_user_id   = $_SESSION['session_user_data']['id'];
	$user_privacy_settings_array = $adminObj->getcontentSettingSqlArray($table_name='user_privacy_settings',$coloum_name_str='*',$updated_on_field='user_id',$updated_on_value=$session_user_id,$otherfields=null , $returnType='');
	$categoryDetail = $adminObj->functionContenPrivacySetting($tablenamelang, $user_privacy_settings_array,$contentType='categorysubcategory');
}
$parent_subcategory_str = (isset($_SESSION['parent_subcategory']))?$_SESSION['parent_subcategory']:'';
if(isset($parent_subcategory_str) && $parent_subcategory_str!=''){
	$parent_id_array = explode('-', $parent_subcategory_str);
	$parent_id       = (isset($parent_id_array[0]))?$parent_id_array[0]:'';
	$categoryOne     = $langObj->functionGetSetting($tablename='category', $dmlType='1', $parent_id);
	$category_name   = (isset($categoryOne['category_name']))?$categoryOne['category_name']:'';
	$categoryname_id = str_replace(']','',(str_replace('[','',(str_replace(' ','',trim($category_name))))));
}
//echo '<pre>';print_r($categoryDetail);echo '</pre>';
?>

<h2>Categories<?php if($session_set!='0'){?><div class="addmore"><a href="<?php echo URL_SITE; ?>/setting.php">+Add More</a></div><?php } ?></h2>
<ul>
	<?php if(!empty($categoryDetail)){ ?>

		<form method="POST" action="" id="categoryfilterform">
				<?php foreach($categoryDetail as $categorynamekey => $subcategoryAll){
			    $parent_div_id    = str_replace(']','',(str_replace('[','',(str_replace(' ','',trim($categorynamekey))))));
				$parent_cat_count = count($subcategoryAll['subCategory']);
				?>
				<li>
					<div id="parent_category_<?php echo $parent_div_id;?>" class="add-icon">
					   <a title="<?php echo $categorynamekey;?>" href="javascript:;"><?php echo $categorynamekey;?></a> (<?php echo $parent_cat_count;?>)
					</div>
				</li>
				<?php if(!empty($subcategoryAll['subCategory'])){ ?>
					<ul class="sub-cat" id="sub_category_<?php echo $parent_div_id;?>" <?php if(isset($categoryname_id) && $categoryname_id==$parent_div_id){?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>>
					    <?php foreach($subcategoryAll['subCategory'] as $key => $subcategory){?>
							<?php if(is_numeric($key)) {?>
						          <li>
								      <a class="sub-category-name-class" id="sub-category-name-id-<?php echo $subcategory['parent_id'];?>-<?php echo $subcategory['id'];?>" onclick="functionFilterSubCategory('<?php echo $subcategory['parent_id'];?>-<?php echo $subcategory['id'];?>','<?php echo $_SERVER['PHP_SELF']?>');" title="<?php echo $subcategory['category_name'];?>" href="javascript:;"><?php echo $subcategory['category_name'];?></a>
							      </li>
								  <?php
								  if(isset($_SESSION['parent_subcategory']) && $subcategory['parent_id'].'-'.$subcategory['id']==$_SESSION['parent_subcategory']){?>
								  <script type="text/javascript">
								  <!--
								   jQuery(document).ready(function(){							
										//jQuery("#sub-category-name-id-<?php echo $subcategory['parent_id'];?>-<?php echo $subcategory['id'];?>").toggle();								
										jQuery("#sub-category-name-id-<?php echo $subcategory['parent_id'];?>-<?php echo $subcategory['id'];?>").addClass("labelred");
									});									
								  //-->
								  </script>
								  <?php } ?>
						    <?php } ?>
						<?php } ?>
					</ul>
				<?php } ?>

				<script type="text/javascript">
				$(document).ready(function(){
					$("#parent_category_<?php echo $parent_div_id;?>").click(function(){
						$("#sub_category_<?php echo $parent_div_id;?>").toggle('slow');				
					});
				});
				</script>

			<?php } ?>

		</form>

	<?php } else { ?>
		<li><a title="No Category" href="javascript:;">No Category</a></li>
	<?php } ?>
</ul>