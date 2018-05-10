<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
function post_estates(){
	global $base_url, $user;
	if($user->uid == 0){
		unset($_POST);
		drupal_goto($base_url.'/user');
		exit();
	}
	
	clsSeo::SEO($title='Đăng tin mua bán, thuê và cho thuê nhà đất', $img='', $meta_title='Đăng tin mua bán, thuê và cho thuê nhà đất', $meta_keyword='Đăng tin mua bán, thuê và cho thuê nhà đất', $meta_description='Đăng tin mua bán, thuê và cho thuê nhà đất');

	$clsStdio = new clsStdio();
	$clsCategory = new Category();
	$clsEstates = new Estates();
	$clsProvices = new Provices();
	$clsDictricts = new Dictricts();
	
	if(isset($_POST['txtFormNameEstate'])){
		$frmTitle		= isset($_POST['frmTitle'])? trim($_POST['frmTitle'])  : '';
		$frmContent		= isset($_POST['frmContent'])? trim($_POST['frmContent'])  : '';
		$frmSubCatid	= isset($_POST['frmSubCatid'])? intval($_POST['frmSubCatid'])  : 0;
		$frmCatName		= $clsCategory->getCatNameFromId($frmSubCatid);
		$frmSubCatName 	= '';
		$frmProvice		= isset($_POST['frmProvice'])? intval($_POST['frmProvice'])  : 0;
		$frmDistrict	= isset($_POST['frmDistrict'])? intval($_POST['frmDistrict'])  : 0;
		$frmProviceName = $clsProvices->get_name_provices($frmProvice);
		$frmDistrictName 	= $clsDictricts->get_name_dictrict($frmDistrict);
		$frmAddressMore		= isset($_POST['frmAddressMore'])? trim($_POST['frmAddressMore'])  : '';
		$frmArea	= isset($_POST['frmArea'])? trim(intval($_POST['frmArea']))  : 0;
		$frmPrice	= isset($_POST['frmPrice'])? trim(intval($_POST['frmPrice'])): 0;
		$frmUnit	= isset($_POST['frmUnit'])? trim(intval($_POST['frmUnit']))  : 0;
		$frmContactName		= isset($_POST['frmContactName'])? trim($_POST['frmContactName'])  : '';
		$frmContactPhone	= isset($_POST['frmContactPhone'])? trim($_POST['frmContactPhone'])  : '';
		$frmContactMail		= isset($_POST['frmContactMail'])? trim($_POST['frmContactMail'])  : '';
		
		if($frmContactName==''){
			$frmContactName = $user->fullname;
		}
		if($frmContactPhone==''){
			$frmContactPhone = $user->phone;
		}
		if($frmContactMail==''){
			$frmContactMail = $user->mail;
		}
		$cat_alias='';
		if($frmSubCatid > 0){
			$cat_alias = $clsCategory->getCatAliasFromID($frmSubCatid);
		}else{
			drupal_set_message("Bạn chưa chọn loại bất động sản");
			drupal_goto($base_url.'/dang-tin');exit();
		}
		$frmContactAddress	= isset($_POST['frmContactAddress'])? trim($_POST['frmContactAddress'])  : '';
		$frmTitleAlias 		= isset($_POST['frmTitle'])	? $clsStdio->pregReplaceStringAlias(trim($_POST['frmTitle'])) : '';

		$regexEmail = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		if($frmContactMail!=''){
			if (!preg_match($regexEmail, $frmContactMail)) {
			     drupal_set_message("Email đăng nhập sai mẫu. Vui lòng thử lại");
				 drupal_goto($base_url.'/dang-tin');exit();
			}
		}
		$isPhoneNum=0;
		if(preg_match("/^[0-9() -]+$/", $frmContactPhone)){
		    if (strlen($frmContactPhone) >= 9 && strlen($frmContactPhone) <= 20){
				$isPhoneNum = 1;//true;
			}else{
				 drupal_set_message("Số điện thoại không đúng. Vui lòng thử lại");
				 drupal_goto($base_url.'/dang-tin');exit();
			}
		}else{
			drupal_set_message("Số điện thoại không đúng. Vui lòng thử lại");
			drupal_goto($base_url.'/dang-tin');exit();
		}
		
		if(strlen($frmTitle)>=20 && strlen($frmTitle)<=255 && strlen($frmContent)>=50 && strlen($frmContent)<=3000 && $frmSubCatid>0 && $frmProvice>0 && $frmDistrict>0 && $frmAddressMore!='' && $isPhoneNum==1){
			$data = array(
				'uid'=>$user->uid,
				'title'=>$frmTitle,
				'title_alias'=>$frmTitleAlias,
				'content'=>$frmContent,
				
				'catid'=>$frmSubCatid,
				'cat_name'=>$frmCatName,
				'cat_alias'=>$cat_alias,
				
				'subcatid'=>0,
				'subcat_name'=>' ',
				
				'provice'=>$frmProvice,
				'dictrict'=>$frmDistrict,
				'provice_name'=>$frmProviceName,
				'dictrict_name'=>$frmDistrictName,
				'address_more'=>$frmAddressMore,
				
				'area'=>$frmArea,
				'price'=>$frmPrice,
				'unit'=>$frmUnit,
				
				'contact'=>$frmContactName,
				'phone'=>$frmContactPhone,
				'address'=>$frmContactAddress,
				'mail'=>$frmContactMail,
				
				'order_no'=> 1,
				'created'=>time(),
				'status'=>0,
				
				'meta_title'=>$frmTitle,
				'meta_keywords'=>$frmTitle,
				'meta_description'=>$frmTitle,
			);
			
			$clsUpload = new clsUpload();
			$current_path_img = '';
			$name_img = $clsUpload->check_upload_file('frmImage', $current_path_img, $name_module='estates');
			
			if($name_img!=''){
				$data['img'] = $name_img;
			}
			$query = $clsEstates->insertOne($data);
			if($query){
				drupal_set_message('Bạn đăng tin thành công!');
				drupal_goto($base_url);
			}	
		}else{
			drupal_set_message('Các trường có dấu <span style="color:#ff0000">(*)</span> là bắt buộc. Bạn vui lòng nhập đầy đủ thông tin!');
			unset($_POST);
			drupal_goto($base_url.'/dang-tin');
		}	
	}
	$arrProvice = $clsProvices->list_category();
	$type_id = 5;
	$arrUnit = $clsCategory->list_category(0, $type_id);


	$arrOptionsCategory[0] = t("--Chọn chuyên mục--");
	$clsType = new Type();
	$typeid = $clsType->get_type_id($type_keyword='group_estates', $limit=1);
	$clsCategory->makeListCatFromTypeFull($typeid, 0, 0, $arrOptionsCategory, 20);

	$data = array(
		'arrUnit'=>$arrUnit,
		'arrProvice'=>$arrProvice,
		'arrOptionsCategory'=>$arrOptionsCategory
	);
	$view = theme('post-estate-page', $data);
	return $view;
}
function control_post_estates(){
	global $base_url, $user;
	if($user->uid==0){
		drupal_goto($base_url.'/user');
		exit();
	}
	$clsEstates = new Estates();
	clsSeo::SEO($title='Danh sách tin đăng', $img='', $meta_title='Danh sách tin đăng', $meta_keyword='Danh sách tin đăng', $meta_description='Danh sách tin đăng');

	$sql = db_select($clsEstates->table, 'i')->extend('PagerDefault');
	
	$sql->addField('i', 'id', 'id');
	$sql->addField('i', 'title', 'title');
	$sql->addField('i', 'title_alias', 'title_alias');
	$sql->addField('i', 'cat_alias', 'cat_alias');
	$sql->addField('i', 'content', 'content');
	$sql->addField('i', 'img', 'img');
	$sql->addField('i', 'area', 'area');
	$sql->addField('i', 'price', 'price');
	$sql->addField('i', 'created', 'created');
	$sql->addField('i', 'view_num', 'view');
	
	$sql->addField('i', 'provice_name', 'title_provice');
	$sql->addField('i', 'dictrict_name', 'title_dictrict');
	
	$sql->condition('i.uid', $user->uid, '=');
	//$sql->condition('i.status', 1,'=');
	
	$sql->orderBy('i.id', 'DESC');
	$sql->limit(20);
	
	$arrItem = $sql->execute()->fetchAll();
	$listPage['pager'] = array('#theme' => 'pager','#quantity' => 3);
	
	$data = array(
		'arrItem'=>$arrItem,
		'listPage'=>$listPage,
	);
	$view = theme('list-user-post',$data);
	return $view;
}
function get_list_district(){
	$html = '';
	$clsDictricts = new Dictricts();
	if(isset($_POST['txtProviceId'])){
		$txtProviceId	= isset($_POST['txtProviceId'])? intval($_POST['txtProviceId'])  : 0;
		$txtDicttrictID	= isset($_POST['txtDicttrictID'])? intval($_POST['txtDicttrictID'])  : 0;

		if($txtProviceId!=0){
			$arrDistrict = $clsDictricts->getAll("id, title", "status=1 AND provice_id = $txtProviceId", "", "order_no ASC", 50);
			if(count($arrDistrict)>0){
				$html = '<option value="0">--Quận/Huyện--</option>';
				foreach($arrDistrict as $v){
					$selected = '';
					if($txtDicttrictID > 0 && $v->id == $txtDicttrictID){
						$selected = 'selected = "selected"';
					}

					$html.='<option value="'.$v->id.'" '.$selected.'>'.$v->title.'</option>';
				}
			}else{
				$html = '<option value="0">--Quận/Huyện--</option>';
			}
		}else{
			$html = '<option value="0">--Quận/Huyện--</option>';
		}
		echo $html;exit();
	}
}
function get_list_type_estates(){
	$html = '';
	$clsCategory = new Category();
	if(isset($_POST['txtCatid'])){
		$txtCatid	= isset($_POST['txtCatid'])? intval($_POST['txtCatid'])  : 0;
		if($txtCatid!=0){
			$arrTypeEstate = $clsCategory->getAll("id, title", "status=1 AND parent_id = $txtCatid", "", "order_no ASC", 30);
			if(count($arrTypeEstate)>0){
				$html = '<option value="0">--Loại--</option>';
				foreach($arrTypeEstate as $v){
					$html.='<option value="'.$v->id.'">'.$v->title.'</option>';
				}
			}else{
				$html = '<option value="0">--Loại--</option>';
			}
		}else{
			$html = '<option value="0">--Loại--</option>';
		}
		echo $html;exit();
	}
}
function delelte_item_estate(){
	global $base_url, $user;
	
	$clsEstates = new Estates();
	$classImages= new Img();
	$clsUpload = new clsUpload();
	$getArg = arg();
	$itemId = isset($getArg[1]) ? $getArg[1] : 0;
	
	$getItem = $clsEstates->getByCond("id, img", "id=$itemId AND uid=$user->uid", "", "id DESC", "1");
	
	if($itemId>0 && count($getItem)>0){
		$current_path_img='';
		foreach($getItem as $v){
			$current_path_img .= $v->img;
		}
		if($current_path_img!=''){
			$dir = DRUPAL_ROOT.'/'.$clsUpload->path_image_upload.'/estates/'.$current_path_img;
			if(is_file($dir)){
				unlink($dir);
			}
		}
		$query = $clsEstates->deleteOne($itemId);

		if($query){
			drupal_set_message('Xóa bài viết thành công.');
			drupal_goto($base_url.'/quan-ly-tin-dang');
		}
	}
}
function edit_item_estate(){
	global $base_url, $user;
	
	$clsStdio = new clsStdio();
	$clsCategory = new Category();
	$clsEstates = new Estates();
	$clsProvices = new Provices();
	$clsDictricts = new Dictricts();
	
	$clsImg= new Img();
	
	$getArg = arg();
	$itemId = isset($getArg[1]) ? $getArg[1] : 0;
	
	//check item of user
	$sql = db_select($clsEstates->table, 'i');
	
	$sql->addField('i', 'id', 'id');
	$sql->addField('i', 'title', 'title');
	$sql->addField('i', 'content', 'content');
	$sql->addField('i', 'catid', 'catid');
	$sql->addField('i', 'provice', 'provice');
	$sql->addField('i', 'dictrict', 'dictrict');
	$sql->addField('i', 'address_more', 'address_more');
	$sql->addField('i', 'area', 'area');
	$sql->addField('i', 'price', 'price');
	$sql->addField('i', 'unit', 'unit');
	$sql->addField('i', 'img', 'img');
	$sql->addField('i', 'contact', 'contact');
	$sql->addField('i', 'address', 'address');
	$sql->addField('i', 'phone', 'phone');
	$sql->addField('i', 'mail', 'mail');
	
	$sql->condition('i.id', $itemId,'=');
	$sql->condition('i.uid', $user->uid,'=');
	//$sql->condition('i.status', 1,'=');
	$sql->orderBy('i.id', 'DESC');
	$sql->range(0,1);
	$getItem = $sql->execute()->fetchAll();
	
	$data = array();
	$pathImg='';
	
	if($itemId>0 && count($getItem)>0){
		
		$arrOptionsCategory[0] = t("--Chọn chuyên mục--");
		$clsType = new Type();
		$typeid = $clsType->get_type_id($type_keyword='group_estates', $limit=1);
		$clsCategory->makeListCatFromTypeFull($typeid, 0, 0, $arrOptionsCategory, 20);

		$data = array(
			'getItem'=>$getItem,
			'clsProvices'=>$clsProvices,
			'clsCategory'=>$clsCategory,
			'arrOptionsCategory'=>$arrOptionsCategory
		);
		foreach($getItem as $v){
			$pathImg = $v->img;
		}
	}
	if(isset($_POST['txtFormNameEstate'])){
		$frmTitle		= isset($_POST['frmTitle'])? trim($_POST['frmTitle'])  : '';
		$frmContent		= isset($_POST['frmContent'])? trim($_POST['frmContent'])  : '';
		$frmSubCatid	= isset($_POST['frmSubCatid'])? intval($_POST['frmSubCatid'])  : 0;
		$frmCatName		= $clsCategory->getCatNameFromId($frmSubCatid);
		$frmSubCatName 	= '';
		$frmProvice		= isset($_POST['frmProvice'])? intval($_POST['frmProvice'])  : 0;
		$frmDistrict	= isset($_POST['frmDistrict'])? intval($_POST['frmDistrict'])  : 0;
		$frmProviceName = $clsProvices->get_name_provices($frmProvice);
		$frmDistrictName 	= $clsDictricts->get_name_dictrict($frmDistrict);
		$frmAddressMore		= isset($_POST['frmAddressMore'])? trim($_POST['frmAddressMore'])  : '';
		$frmArea	= isset($_POST['frmArea'])? trim(intval($_POST['frmArea']))  : 0;
		$frmPrice	= isset($_POST['frmPrice'])? trim(intval($_POST['frmPrice'])): 0;
		$frmUnit	= isset($_POST['frmUnit'])? trim(intval($_POST['frmUnit']))  : 0;
		$frmContactName		= isset($_POST['frmContactName'])? trim($_POST['frmContactName'])  : '';
		$frmContactPhone	= isset($_POST['frmContactPhone'])? trim($_POST['frmContactPhone'])  : '';
		$frmContactMail		= isset($_POST['frmContactMail'])? trim($_POST['frmContactMail'])  : '';
		
		if($frmContactName==''){
			$frmContactName = $user->fullname;
		}
		if($frmContactPhone==''){
			$frmContactPhone = $user->phone;
		}
		if($frmContactMail==''){
			$frmContactMail = $user->mail;
		}
		$cat_alias='';
		if($frmSubCatid > 0){
			$cat_alias = $clsCategory->getCatAliasFromID($frmSubCatid);
		}else{
			drupal_set_message("Bạn chưa chọn loại bất động sản");
			drupal_goto($base_url.'/dang-tin');exit();
		}
		$frmContactAddress	= isset($_POST['frmContactAddress'])? trim($_POST['frmContactAddress'])  : '';
		$frmTitleAlias 		= isset($_POST['frmTitle'])	? $clsStdio->pregReplaceStringAlias(trim($_POST['frmTitle'])) : '';

		$regexEmail = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		if($frmContactMail!=''){
			if (!preg_match($regexEmail, $frmContactMail)) {
			     drupal_set_message("Email đăng nhập sai mẫu. Vui lòng thử lại");
				 drupal_goto($base_url.'/dang-tin');exit();
			}
		}
		$isPhoneNum=0;
		if(preg_match("/^[0-9() -]+$/", $frmContactPhone)){
		    if (strlen($frmContactPhone) >= 9 && strlen($frmContactPhone) <= 20){
				$isPhoneNum = 1;//true;
			}else{
				 drupal_set_message("Số điện thoại không đúng. Vui lòng thử lại");
				 drupal_goto($base_url.'/dang-tin');exit();
			}
		}else{
			drupal_set_message("Số điện thoại không đúng. Vui lòng thử lại");
			drupal_goto($base_url.'/dang-tin');exit();
		}
		
		if(strlen($frmTitle)>=20 && strlen($frmTitle)<=255 && strlen($frmContent)>=50 && strlen($frmContent)<=3000 && $frmSubCatid>0 && $frmProvice>0 && $frmDistrict>0 && $frmAddressMore!='' && $isPhoneNum==1){
			$data_update = array(
				'uid'=>$user->uid,
				'title'=>$frmTitle,
				'title_alias'=>$frmTitleAlias,
				'content'=>$frmContent,
				
				'catid'=>$frmSubCatid,
				'cat_name'=>$frmCatName,
				'cat_alias'=>$cat_alias,
				
				'subcatid'=>0,
				'subcat_name'=>' ',
				
				'provice'=>$frmProvice,
				'dictrict'=>$frmDistrict,
				'provice_name'=>$frmProviceName,
				'dictrict_name'=>$frmDistrictName,
				'address_more'=>$frmAddressMore,
				
				'area'=>$frmArea,
				'price'=>$frmPrice,
				'unit'=>$frmUnit,
				
				'contact'=>$frmContactName,
				'phone'=>$frmContactPhone,
				'address'=>$frmContactAddress,
				'mail'=>$frmContactMail,
				
				'order_no'=> 1,
				'created'=>time(),
	
				'meta_title'=>$frmTitle,
				'meta_keywords'=>$frmTitle,
				'meta_description'=>$frmTitle,
			);
			
			$clsUpload = new clsUpload();
			$current_path_img = '';
			$name_img = $clsUpload->check_upload_file('frmImage', $current_path_img, $name_module='estates');
			
			if($name_img!=''){
				$data_update['img'] = $name_img;
			}	
			
			$query = $clsEstates->updateOne($data_update, $itemId);
			if($query){
				drupal_set_message('Bạn cập nhật tin thành công.');
				drupal_goto($base_url.'/quan-ly-tin-dang');
			}	
		}else{
			drupal_set_message('Các trường có dấu <span style="color:#ff0000">(*)</span> là bắt buộc. Bạn vui lòng nhập đầy đủ thông tin!');
			unset($_POST);
			drupal_goto($base_url.'/sua-tin-dang/'.$itemId);
		}	
	}
	$view = theme('edit-estate-page', $data);
	return $view;
	
}
