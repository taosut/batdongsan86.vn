<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
function indexDictricts(){
	global $base_url;

	$_Dictricts = new _Dictricts();

	$totalItem = $_Dictricts->countItem($_fields="id");
	$listItem = $_Dictricts->listItemPost();

	$data = array(
			'title'=>'Quản lý bài viết',
			'listItem' => $listItem,
			'totalItem' =>$totalItem,
	);

	$view = theme('dictricts',$data);
	return $view;
}

function formDictrictsAction(){
	global $base_url, $user;

	$clsStdio = new clsStdio();
	$clsUpload = new clsUpload();
	$_Dictricts = new _Dictricts();

	$fields = clsForm::buildItemFields($_Dictricts->listInputForm());
	$data = array('fields'=>$fields);

	//get item update
	$param = arg();
	if(isset($param[2]) && isset($param[3]) && $param[2]=='edit' && $param[3]>0){
		$arrOneItem = $_Dictricts->getOne("*", $param[3]);
		foreach ($data['fields'] as $key => $filed) {
			$data['fields'][$key]['value']=$arrOneItem[0]->$key;
		}
	}

	//check post: insert or update
	if(!empty($_POST) && $_POST['txtFormName']=='txtFormName'){
		$require_post = array();

		$data_post = array();
		$data_post['uid ']=$user->uid;
		$data_post['created']=time();

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

		unset($_POST);
		if(count($require_post)>0){
			foreach ($require_post as $k => $v) {
				form_set_error($k, $v);
			}
			unset($data_post);
		}else{
			if($data['fields']['id']['value']>0){
				$query = $_Dictricts->updateOne($data_post, $data['fields']['id']['value']);
				unset($data_post);
				drupal_set_message('Sửa bài viết thành công.');
				drupal_goto($base_url.'/admincp/dictricts');
			}else{
				$query = $_Dictricts->insertOne($data_post);
				unset($data_post);
				if($query){
					drupal_set_message('Thêm bài viết thành công.');
					drupal_goto($base_url.'/admincp/dictricts');
				}
			}
		}
	}

	$view = theme('dictricts-form',$data);
	return $view;
}

function deleteDictrictsAction(){
	global $base_url;
	$_Dictricts = new _Dictricts();
	$clsUpload = new clsUpload();

	if(isset($_POST) && $_POST['txtFormName']=='txtFormName'){
		$listId = isset($_POST['checkItem'])? $_POST['checkItem'] : 0;
		foreach($listId as $item){
			if($item > 0){
				$query = $_Dictricts->deleteOne($item);
			}
		}
		unset($listId);
		drupal_set_message('Xóa bài viết thành công.');

	}
	drupal_goto($base_url.'/admincp/dictricts');
}
function getdictrictsDictrictsAction(){
	global $base_url;
	$html='';
	if(empty($_POST)){
		drupal_goto($base_url);
	}
	$provice_id = isset($_POST['provice_id']) ? intval($_POST['provice_id']) : 0;
	$estates_id = isset($_POST['estates_id']) ? intval($_POST['estates_id']) : 0;
	if($provice_id > 0){
		$clsDictricts = new Dictricts();
		if($estates_id > 0){
			$clsEstates = new _Estates();
			$dictrict_id = $clsEstates->get_dictrict_id($estates_id);
			$html .= $clsDictricts->list_dictricts($provice_id, $dictrict_id);
		}else{
			$html .= $clsDictricts->list_dictricts($provice_id);
		}
		
		
	}
	echo $html;exit();
}