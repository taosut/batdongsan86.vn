<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
$clsCategory = new Category();
$clsEstates = new Estates();
$arrItem = $clsEstates->getAll("id, catid", "", "", "id ASC", "");
foreach($arrItem as $v){
	if($v->id > 0){
		$catalias = $clsCategory->getCatAliasFromID($v->catid);
		$data = array(
			'cat_alias'=>$catalias,
		);
		$query = $clsEstates->updateOne($data, $v->id);
	}
}
function indexEstates(){
	global $base_url;

	$_Estates = new _Estates();

	$totalItem = $_Estates->countItem($_fields="id");
	$listItem = $_Estates->listItemPost();

	$data = array(
			'title'=>'Quản lý bài viết',
			'listItem' => $listItem,
			'totalItem' =>$totalItem,
	);

	$view = theme('estates',$data);
	return $view;
}

function formEstatesAction(){
	global $base_url, $user;

	$clsStdio = new clsStdio();
	$clsUpload = new clsUpload();
	$_Estates = new _Estates();
	$EstatesImg = new Img();
	$fields = clsForm::buildItemFields($_Estates->listInputForm());
	$data = array('fields'=>$fields);

	//get item update
	$param = arg();
	if(isset($param[2]) && isset($param[3]) && $param[2]=='edit' && $param[3]>0){
		$arrOneItem = $_Estates->getOne("*", $param[3]);
		foreach ($data['fields'] as $key => $filed) {
			if($key!='txtImagesPost'){
				$data['fields'][$key]['value']=$arrOneItem[0]->$key;
			}
		}
		//get all img
		$arrImg = array();
		if(count($arrOneItem)>0){
			$arrImg = $EstatesImg->getAll("id, path", "eid=$param[3]", "", "id ASC", 20);
			$data['fields']['txtImagesPost']['value'] = $arrImg;
		}
	}
	//img item post current
	$current_path_img =  $data['fields']['img']['value'];
	if($current_path_img!=''){
		$data['fields']['img']['value'] = '<div class="item-post"><img src="'.$base_url.'/'.$clsUpload->path_image_upload.'/estates/'.$current_path_img.'" /></div>';
	}
	//check post: insert or update
	if(!empty($_POST) && $_POST['txtFormName']=='txtFormName'){
		$require_post = array();

		$data_post = array();
	
		$data_post['contact ']=$user->name;
		$data_post['created']=time();
		$data_post['view_num'] = 0;
		
		if(isset($data['fields']['txtImagesPost'])){
			unset($data['fields']['txtImagesPost']);
		}
		foreach ($data['fields'] as $key => $field) {
			$data_post[$key] = clsForm::itemPostValue($key);
			$data['fields'][$key]['value']=$data_post[$key];

			if(isset($field['require']) && $field['require']=='require' && $data_post[$key]==''){
				$require_post[$key] = t($field['label']).' '.t('không được rỗng!');
			}

			if($key=='title'){
				$data_post['title_alias']=$clsStdio->pregReplaceStringAlias(clsForm::itemPostValue('title'));
			}
		 }
		
		if(count($require_post)>0){
			foreach ($require_post as $k => $v) {
				form_set_error($k, $v);
			}
			unset($data_post);
		}else{
			$name_img = $clsUpload->check_upload_file('txtImg', $current_path_img, $name_module='estates');
			if($name_img!=''){
				$data_post['img'] = $name_img;
			}else{
				unset($data_post['img']);
			}
			if($data_post['catid']){
				$_Category = new _Category();
				$catitem = $_Category->get_one_cat_from_catid($data_post['catid']);
				if(count($catitem) > 0){
					foreach ($catitem as $cat) {
						$data_post['cat_name'] = $cat->title;
						$data_post['cat_alias'] = $cat->title_alias;
					}	
				}else{
					$data_post['cat_name'] = '';
					$data_post['cat_alias'] = '';
				}	
			}

			if($data_post['provice']){
				$clsProvices = new _Provices();
				$proviceitem = $clsProvices->get_one_provice_from_catid($data_post['provice']);
				if(count($proviceitem) > 0){
					foreach ($proviceitem as $provice) {
						$data_post['provice_name'] = $provice->title;
					}	
				}else{
					$data_post['provice_name'] = '';
				}	
			}

			if($data_post['dictrict']){
				$clsDictricts = new _Dictricts();
				$dictrictitem = $clsDictricts->get_one_dictrict_from_catid($data_post['dictrict']);
				if(count($dictrictitem) > 0){
					foreach ($dictrictitem as $dictrict) {
						$data_post['dictrict_name'] = $dictrict->title;
					}	
				}else{
					$data_post['dictrict_name'] = '';
				}	
			}
			if($data_post['address'] != ''){
				$data_post['address_more'] = $data_post['address'];
			}
			
			if($data_post['uid'] >0 ){
			
			}else{
				$data_post['uid']=$user->uid;
			}

			if($data['fields']['id']['value']>0){
				unset($data_post['created']);
				$query = $_Estates->updateOne($data_post, $data['fields']['id']['value']);
				//save img
				$link_file = isset($_POST['link_file']) ? $_POST['link_file'] : array();
				if(count($link_file)>0){
					foreach($link_file as $i){
						$dataImg = array(
							'uid'=>$user->uid,
							'path' =>$i,
							'created' =>time(),
							'status'=>1
						);
						if(isset($param[2]) && isset($param[3]) && $param[2]=='edit' && $param[3]>0){
							$dataImg['eid'] = $data['fields']['id']['value'];
						}
						$EstatesImg->insertOne($dataImg);
					};
				}

				unset($data_post);
				drupal_set_message('Sửa bài viết thành công.');
				drupal_goto($base_url.'/admincp/estates');
			}else{
				//$query = $_Estates->insertOne($data_post);
				$id = db_insert($_Estates->table)->fields($data_post)->execute();
				//save img
				$link_file = isset($_POST['link_file']) ? $_POST['link_file'] : array();
				if(count($link_file)>0){
					foreach($link_file as $i){
						$dataImg = array(
							'uid'=>$user->uid,
							'eid'=>$id,
							'path' =>$i,
							'created' =>time(),
							'status'=>1
						);
						$EstatesImg->insertOne($dataImg);
					};
				}

				unset($data_post);
				if($id){
					drupal_set_message('Thêm bài viết thành công.');
					drupal_goto($base_url.'/admincp/estates');
				}
			}
		}
	}

	$view = theme('estates-form',$data);
	return $view;
}

function deleteEstatesAction(){
	global $base_url;
	$_Estates = new _Estates();
	$clsUpload = new clsUpload();
	$EstatesImg = new Img();
	
	if(isset($_POST) && $_POST['txtFormName']=='txtFormName'){
		$listId = isset($_POST['checkItem'])? $_POST['checkItem'] : 0;
		foreach($listId as $item){
			if($item > 0){

				$arrName = $_Estates->getByCond("img", "id=$item", "", "", "1");
				$current_path_img='';
				foreach($arrName as $v){
					$current_path_img .= $v->img;
				}

				if($current_path_img!=''){
					$dir = DRUPAL_ROOT.'/'.$clsUpload->path_image_upload.'/estates/'.$current_path_img;
					if(is_file($dir)){
						unlink($dir);
					}
				}
				$query = $_Estates->deleteOne($item);
				//delete all img
				$arrPath = $EstatesImg->getAll("path", "eid=$item", "", "id ASC", "200");
				if(count($arrPath)>0){
					foreach($arrPath as $v){
						$path = $v->path;
						$dir = DRUPAL_ROOT.'/uploads/images/estates/'.$path;
						if($path!='' && is_file($dir)){
							unlink(DRUPAL_ROOT.'/uploads/images/estates/'.$path);
						}
					}
					$EstatesImg->deleteByCond('eid', $item);
				}
			}
		}
		unset($listId);
		drupal_set_message('Xóa bài viết thành công.');

	}
	drupal_goto($base_url.'/admincp/estates');
}

function uploadFileEstatesAction(){
	$clsUpload = new clsUpload();
	$data = $clsUpload->upload($_name='txtImagesPost', 
							   $_file_ext='jpg,jpeg,png,gif', 
							   $_max_file_size=10*1024*1024, 
							   $_module='estates', 
							   $type_json=1
							   );
	return $data;
}

function deleteFileEstatesAction(){
	global $base_url;
	if(empty($_POST)){
		drupal_goto($base_url);
	}
	$link = isset($_POST['link']) ? trim($_POST['link']) : '';
	if($link!=''){
		unlink(DRUPAL_ROOT.'/uploads/images/estates/'.$link);
	}
	exit();
}

function deleteDBFileEstatesAction(){
	global $base_url;
	if(empty($_POST)){
		drupal_goto($base_url);
	}
	$link = isset($_POST['link']) ? trim($_POST['link']) : '';
	$id_file = isset($_POST['id_file']) ? $_POST['id_file']: 0;
	if($id_file>0){
		$EstatesImg = new Img();
		$EstatesImg->deleteOne($id_file);
	}
	$dir = DRUPAL_ROOT.'/uploads/images/estates/'.$link;
	if($link!='' && is_file($dir)){
		unlink(DRUPAL_ROOT.'/uploads/images/estates/'.$link);
	}
	exit();
}