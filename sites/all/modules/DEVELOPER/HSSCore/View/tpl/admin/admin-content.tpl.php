<?php 
/*
* @Created by:
* @Author	: pt.soleil@gmail.com
* @Date 	: 2013
* @Version	: 1.0 
*/
global $base_url;

/*count user*/
function count_list_user(){
	$clsUsers = new Users();
	$total_users = $clsUsers->countItem($_fields="uid", $_cond="uid>1", $_groupby="", $_oderby="uid ASC", $_limit="");
	return $total_users;
}

function count_list_user_not_active(){
	$clsUsers = new Users();
	$total_users_not_active = $clsUsers->countItem($_fields="uid", $_cond="uid>1 AND status=0", $_groupby="", $_oderby="uid ASC", $_limit="");
	return $total_users_not_active;
}
/*count estates*/
function count_list_estates(){
	$_Type = new _Type();
	$typeid = $_Type->get_list_type_id($type_keyword='group_estates', $limit=1);
	$arrListCat = list_name_category(0,$typeid, 0, 'estates');
	return $arrListCat;	
}
/*count news*/
function count_list_news(){
	$_Type = new _Type();
	$typeid = $_Type->get_list_type_id($type_keyword='group_news', $limit=1);
	$arrListCat = list_name_category(0,$typeid, 0 , 'news');
	return $arrListCat;	
}

function list_name_category($_catid=0, $type_id=0, $_parent_id=0, $type_name=''){
		
		$clsCategory = new Category();
		$clsEstates = new  Estates();
		$clsNews = new News();
		if($type_id > 0){
			$arrListCat = $clsCategory->getAll("id,title", "parent_id=0 AND type_id=$type_id AND status=1", "", "id ASC", "20");
		}else{
			$arrListCat = $clsCategory->getAll("id,title", "parent_id=0 AND status=1", "", "id ASC", "20");
		}
		if($_parent_id>0){
			$arrListCat = $clsCategory->getAll("id,title", "parent_id>0 AND type_id=$type_id AND status=1", "", "id ASC", "20");
		}
		
		$html='';
		foreach($arrListCat as $catid){
			//catid
			$cat_id = $catid->id;
			if($catid->id > 0){
				if($type_name == "estates"){
						$total_post_in_cat_num = $clsEstates->countItem($_fields="id", $_cond="catid=$cat_id AND status=1", $_groupby="", $_oderby="id ASC", $_limit="");
				}else{
					$total_post_in_cat_num = $clsNews->countItem($_fields="id", $_cond="catid=$cat_id AND status=1", $_groupby="", $_oderby="id ASC", $_limit="");
				}
				if($total_post_in_cat_num == 0){
					$total_post_in_cat_num = "--";
				}
				$html .= '<div class="category-parent-name"><span class="name-title">'.$catid->title.'</span><span class="num-count-post">'.$total_post_in_cat_num.'</span></div>';
				//sub catid
				$parentS = $catid->id;
				$arrListSubCat = $clsCategory->getAll("id,title", "parent_id=$parentS AND parent_id>0 AND status=1", "", "id ASC", "50");
				foreach($arrListSubCat as $subCatid){
					$subcatid = $subCatid->id;
					if($type_name == "estates"){
						$total_post_in_cat = $clsEstates->countItem($_fields="id", $_cond="catid=$subcatid AND status=1", $_groupby="", $_oderby="id ASC", $_limit="");
					}else{
						$total_post_in_cat = $clsNews->countItem($_fields="id", $_cond="catid=$subcatid AND status=1", $_groupby="", $_oderby="id ASC", $_limit="");
					}
					
					$html .= '<div class="category-child-name"><span class="name-title">--'.$subCatid->title.'</span><span class="num-count-post">'.$total_post_in_cat.'</span></div>';
				}	
			}	
		}
		return $html;	
	}
	$count_list_user = count_list_user();
	$count_list_user_not_active = count_list_user_not_active();
	$count_list_news= count_list_news();
	$count_list_estates = count_list_estates();
?>
<div class="wrapper-admin-cpanel">
	<div class="notification-global">
		<div class="title-global">Bảng thống kê</div>
	</div>
	<div class="content-global">
		<div class="wrapp-content-global">
			<div class="list-item-content-global">
				<div class="left-item-content-global">
					<div class="item-content-global">
						<div class="title-item-content-global">Thống kê số thành viên</div>
						<div class="content-item-content-global">
							<div class="item-global-total"><span class="lb-txt-num">Tổng số thành viên:</span> <span class="num-total-txt"><?php echo $count_list_user ?></span></div>
							<div class="item-global-total"><span class="lb-txt-num">Số thành viên bị khóa:</span> <span class="num-total-txt"><?php echo $count_list_user_not_active ?></span></div>
						</div>
					</div>
					<div class="item-content-global">
						<div class="title-item-content-global">Thống kê số tin đăng bất động sản</div>
						<div class="content-item-content-global">
							<div class="item-global-total">
								<?php print_r($count_list_estates) ?>
							</div>
						</div>
					</div>
				</div>
				<div class="right-item-content-global">
					<div class="item-content-global">
						<div class="title-item-content-global">Thống kê số tin tức chuyên mục</div>
						<div class="content-item-content-global">
							<div class="item-global-total">
								<?php print_r($count_list_news) ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

