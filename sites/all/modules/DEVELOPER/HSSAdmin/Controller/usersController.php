<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
function indexUsers(){
	global $base_url;

	$_Users = new _Users();

	$totalItem = $_Users->countItem("uid", "uid > 1", "", "", "");
	$listItem = $_Users->listItemPost();
	
	$data = array(
			'title'=>'Quản lý người dùng',
			'listItem' => $listItem,
			'totalItem' =>$totalItem,
	);

	$view = theme('users',$data);
	return $view;
}

function formUsersAction(){
	global $base_url, $user;
	$_Users = new _Users();

	$fields = clsForm::buildItemFields($_Users->listInputForm());
	$data = array('fields'=>$fields);
	//get item update
	$param = arg();
	
	if(isset($param[2]) && isset($param[3]) && $param[2]=='edit'){
		$arrOneItem = $_Users->getOne("*", $param[3]);
		if(count($arrOneItem)>0){
			foreach ($data['fields'] as $key => $filed) {
				if($key != 'repass'){
					$data['fields'][$key]['value']=$arrOneItem[0]->$key;
				}
			}
			$data['fields']['name']['attr'] = 'readonly="readonly", style="background:#f2f2f2"';
			$data['fields']['pass']['value'] = '';
		}
	}
	//check post: insert or update
	if(!empty($_POST) && $_POST['txtFormName']=='txtFormName'){
		$require_post = array();

		$data_post = array();
		$data_post['created']=time();

		foreach ($data['fields'] as $key => $field) {
			$data_post[$key] = clsForm::itemPostValue($key);
			$data['fields'][$key]['value']=$data_post[$key];

			if(isset($field['require']) && $field['require']=='require' && $data_post[$key]==''){
				$require_post[$key] = t($field['label']).' '.t('không được rỗng!');
			}
		 }

		unset($_POST);
		if(count($require_post)>0){
			foreach ($require_post as $k => $v) {
				form_set_error($k, $v);
			}
			unset($data_post);
		}else{
			require_once  DRUPAL_ROOT.'/'.variable_get('password_inc', 'includes/password.inc');
			if($data_post['repass'] == $data_post['pass']){
				$data_post['pass'] = user_hash_password(trim($data_post['pass']));
				unset($data_post['repass']);
				if($data['fields']['uid']['value']>0){
					if(count($arrOneItem)>0){
						if($arrOneItem[0]->name != $data_post['name']){
							form_set_error('name', 'Tên đăng nhập không được thay đổi!');
						}else{
							$arrOneCheckMail = $_Users->getByCond("mail", "name<>'".$data_post['name']."' AND mail='".$data_post['mail']."'", "", "uid ASC", 1);						
							if(count($arrOneCheckMail)>0){
								form_set_error('mail', 'Email đã tồn tại!');
							}else{
								$_UsersRoles = new _UsersRoles();
								$_UsersRoles->deleteByCond("uid", $data_post['uid']);
								$dataRole = array(
									'rid' => $data_post['rid'],
									'uid' => $data_post['uid'],
								);
								$_UsersRoles->insertOne($dataRole);
								
								$query = $_Users->updateOne($data_post, $data['fields']['uid']['value']);
								unset($data_post);
								drupal_set_message('Sửa thông tin người dùng thành công.');
								drupal_goto($base_url.'/admincp/users');
							}
						}
					}
				}else{
					//check user exists and add
					$arrOneItem = $_Users->getByCond("name, mail", "name='".$data_post['name']."' OR mail='".$data_post['mail']."'", "", "uid ASC", 1);
					if(count($arrOneItem)>0){
						form_set_error('name', 'Tên đăng nhập hoặc email đã tồn tại!');
						$query = 0;
					}else{
						$uid = db_next_id(db_query('SELECT MAX(uid) FROM {users}')->fetchField());
						$_UsersRoles = new _UsersRoles();
						$dataRole = array(
							'rid' => $data_post['rid'],
							'uid' => $uid,
						);
						$_UsersRoles->insertOne($dataRole);
						
						$data_post['uid']=$uid;
						$query = $_Users->insertOne($data_post);
						drupal_set_message('Thêm người dùng thành công.');
						drupal_goto($base_url.'/admincp/users');
					}
					unset($data_post);
				}
			}else{
				form_set_error('repass', 'Mật khẩu không khớp!');
			}
		}
	}

	$view = theme('users-form',$data);
	return $view;
}

function deleteUsersAction(){
	global $base_url, $user;
	$_Users = new _Users();
	if(isset($_POST) && $_POST['txtFormName']=='txtFormName'){
		$listId = isset($_POST['checkItem'])? $_POST['checkItem'] : 0;
		foreach($listId as $item){
			if($item > 0){
				$query = $_Users->deleteOne($item);
				$_UsersRoles = new _UsersRoles();
				$_UsersRoles->deleteByCond("uid", $item);
			}
		}
		unset($listId);
		drupal_set_message('Xóa bài viết thành công.');
	}
	drupal_goto($base_url.'/admincp/users');
}