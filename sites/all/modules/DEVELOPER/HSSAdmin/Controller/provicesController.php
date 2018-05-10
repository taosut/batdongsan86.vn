<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
function indexProvices(){
	global $base_url;

	$_Provices = new _Provices();

	$totalItem = $_Provices->countItem($_fields="id");
	$listItem = $_Provices->listItemPost();

	$data = array(
			'title'=>'Quản lý bài viết',
			'listItem' => $listItem,
			'totalItem' =>$totalItem,
	);

	$view = theme('provices',$data);
	return $view;
}

function formProvicesAction(){
	global $base_url, $user;

	$clsStdio = new clsStdio();
	$clsUpload = new clsUpload();
	$_Provices = new _Provices();

	$fields = clsForm::buildItemFields($_Provices->listInputForm());
	$data = array('fields'=>$fields);

	//get item update
	$param = arg();
	if(isset($param[2]) && isset($param[3]) && $param[2]=='edit' && $param[3]>0){
		$arrOneItem = $_Provices->getOne("*", $param[3]);
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
				$query = $_Provices->updateOne($data_post, $data['fields']['id']['value']);
				unset($data_post);
				drupal_set_message('Sửa bài viết thành công.');
				drupal_goto($base_url.'/admincp/provices');
			}else{
				$query = $_Provices->insertOne($data_post);
				unset($data_post);
				if($query){
					drupal_set_message('Thêm bài viết thành công.');
					drupal_goto($base_url.'/admincp/provices');
				}
			}
		}
	}

	$view = theme('provices-form',$data);
	return $view;
}

function deleteProvicesAction(){
	global $base_url;
	$_Provices = new _Provices();
	$clsUpload = new clsUpload();

	if(isset($_POST) && $_POST['txtFormName']=='txtFormName'){
		$listId = isset($_POST['checkItem'])? $_POST['checkItem'] : 0;
		foreach($listId as $item){
			if($item > 0){
				$query = $_Provices->deleteOne($item);
			}
		}
		unset($listId);
		drupal_set_message('Xóa bài viết thành công.');

	}
	drupal_goto($base_url.'/admincp/provices');
}