<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
function page_register(){
	global $base_url, $user;
	if($user->uid!=0){
		drupal_goto($base_url);
	}
	drupal_set_title('Đăng ký thành viên');
	clsSeo::SEO($title='Đăng ký thành viên', $img='', $meta_title='Đăng ký thành viên', $meta_keyword='Đăng ký thành viên', $meta_description='Đăng ký thành viên');
	create_account();
	$view = theme('page-register');
	return $view;
}
function create_account(){
	global $base_url;
	if(isset($_POST['dologin'])){
		$clsUsers = new Users();
		$timestamp = REQUEST_TIME;
    	$timestamp = $timestamp.'-'.$_SERVER['SERVER_NAME'];
		
		$frmMail 	= isset($_POST['frmMail'])? trim($_POST['frmMail'])  : '';
		$frmPass 	= isset($_POST['frmPass']) 	? trim($_POST['frmPass'])  : '';
		$frmRePass 	= isset($_POST['frmRePass'])? trim($_POST['frmRePass'])  : '';
		
		$frmPhone 	= isset($_POST['frmPhone'])? trim($_POST['frmPhone'])  : '';
		$frmGender 	= isset($_POST['frmGender'])? trim($_POST['frmGender'])  : 1;
		$frmFullname= isset($_POST['frmFullname'])? trim($_POST['frmFullname'])  : '';
		
		$frmBorn	= isset($_POST['frmBorn'])? trim($_POST['frmBorn'])  : '';
		$frmYahoo 	= isset($_POST['frmYahoo'])? trim($_POST['frmYahoo'])  : '';
		$frmSkype 	= isset($_POST['frmSkype'])? trim($_POST['frmSkype'])  : '';
		
		$frmIntro 	= isset($_POST['frmIntro'])? trim($_POST['frmIntro'])  : '';
		$frmAddress 	= isset($_POST['frmAddress'])? trim($_POST['frmAddress'])  : '';
		/*
		$security_code 	= isset($_POST['security_code'])? trim($_POST['security_code'])  : '';
		$code = $_SESSION['security_code'];
		if($security_code!='' && $code != $security_code){
			 drupal_set_message("Bạn nhập mã an toàn sai. Vui lòng thử lại!");
			 drupal_goto($base_url.'/dang-ky');exit();
		}
		*/
		$regexEmail = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		
		if (!preg_match($regexEmail, $frmMail)) {
		     drupal_set_message("Email đăng nhập sai mẫu. Vui lòng thử lại");
			 drupal_goto($base_url.'/dang-ky');exit();
		}
		
		$isPhoneNum=0;
		if(preg_match("/^[0-9() -]+$/", $frmPhone)){
		    if (strlen($frmPhone) >= 9 && strlen($frmPhone) <= 20){
				$isPhoneNum = 1;//true;
			}else{
				 drupal_set_message("Số điện thoại không đúng. Vui lòng thử lại");
				 drupal_goto($base_url.'/dang-ky');exit();
			}
		}else{
			drupal_set_message("Số điện thoại không đúng. Vui lòng thử lại");
			drupal_goto($base_url.'/dang-ky');exit();
		}
		
		if($frmAgree='on' && $frmMail!='' && $isPhoneNum==1 && strlen($frmPass)>=6 && $frmPass == $frmRePass && $frmFullname!='' && $frmAddress!=''){
			$checkEmail = check_email_exists($frmMail);
			if($checkEmail>0){
				drupal_set_message("Email đăng nhập đã tồn tại. Vui lòng thử lại!");
				drupal_goto($base_url.'/dang-ky');exit();
			}else{
				$userId = db_next_id(db_query('SELECT MAX(uid) FROM {users}')->fetchField());
				require_once DRUPAL_ROOT . '/' . variable_get('password_inc', 'includes/password.inc');
				$editPassMd5 = user_hash_password(trim($frmPass));
				if($userId){
					$data = array(
								'uid' => $userId,
								'name' => $frmMail,
								'pass' => $editPassMd5,
								'mail' => $frmMail,
								'fullname' => $frmFullname,
								'phone' => $frmPhone,
								'intro_user' => $frmIntro,
								'gender' => $frmGender,
								'born' => $frmBorn,
								'yahoo' => $frmYahoo,
								'skype' => $frmSkype,
								'address' => $frmAddress,
								'active_code'=>$timestamp,
								'created' => time(),
								'status' => 0
							);
						
						$sql = $clsUsers->insertOne($data);
						//set roler
						$roleId = 5;
						$sql = db_query("INSERT INTO {users_roles} (uid, rid) VALUES ('$userId','$roleId')");
						
						$timestamp = REQUEST_TIME;
					    $timestamp = base64_encode(strtr($timestamp, '-_', '+/'));
						$linkpath = $base_url.'/dang-ky/kich-hoat-tai-khoan/'.$userId.'/?active_code='.$timestamp;
						
						$fromEmail = "admin@batdongsan86.vn";
						$contentEmail = '';
						$contentEmail.='<br/>Bạn tạo tài khoản thành công! Vui lòng click liên kết để kích hoạt tài khoản<br/>';
						$contentEmail.='<br/><a href="'.$linkpath.'">'.$linkpath.'</a><br/>';
						$contentEmail.='<br/>Mail đăng nhập: '.$frmMail."<br/>";
						$contentEmail.='<br/>Mật khẩu: '.$frmPass."<br/>";
						
						auto_send_mail_register('HSSProfiles', $frmMail, $fromEmail, 'Đăng ký từ website: batdongsan86.vn', $contentEmail);
						
						drupal_set_message('Bạn đã đăng ký thành công. Vui lòng kiểm tra email để kích hoạt!');
						drupal_goto($base_url);
					}
			}
		}else{
			 drupal_set_message("Thông tin bạn nhập chưa đúng. Vui lòng thử lại!");
			 drupal_goto($base_url.'/dang-ky');exit();
		}
		
	}
}
function page_register_actitive(){
	global $user, $base_url;
    
	$code = $_GET['active_code'];
	$decode = '';
	if($code){
	   $decode = base64_decode($code).'-'.$_SERVER['SERVER_NAME'];
	    $checkActiveCode = db_query("SELECT us.active_code FROM {users} AS us WHERE us.active_code = '{$decode}'")->fetchField();
		
		if($checkActiveCode != 'activated'){
			$uid = db_query('SELECT uid FROM {users} WHERE active_code =:active_code ',array(':active_code' => $decode))->fetchField();
			$check = db_update('users')
          			 ->fields(array(
          							'status' => 1,
          							'active_code' => 'activated',
          					 ))
          			->condition('active_code', $decode)
         			->condition('status', '1','<>')
          			->execute();
					
			 if($check){
			 	drupal_set_message(t('Bạn tạo tài khoản thành công!'));
				 drupal_goto($base_url);
			 }else{
			 	 drupal_set_message(t('Tài khoản này đã kích hoạt!'));
				 drupal_goto($base_url);
			 }		
		}	
	}
}
function check_email_exists($email=''){
	$clsUsers = new Users();
	if($email !=''){
		$sql = $clsUsers->getByCond("name", "name = '".$email."'");
		if(count($sql) > 0){
			return 1;
		}
	}
	return 0;
}
function change_info_user(){
	global $base_url, $user;
	if($user->uid==0){
		drupal_goto($base_url.'/user');
		exit();
	}
	clsSeo::SEO($title='Quản lý thông tin cá nhân', $img='', $meta_title='Quản lý thông tin cá nhân', $meta_keyword='Quản lý thông tin cá nhân', $meta_description='Quản lý thông tin cá nhân');
	if(isset($_POST['txtFormInfoChange'])){
		$clsUsers = new Users();
		
		$txtChangeFullname	= isset($_POST['txtChangeFullname'])? trim($_POST['txtChangeFullname'])  : '';
		$txtChangePhone 	= isset($_POST['txtChangePhone']) 	? trim($_POST['txtChangePhone'])  : '';
		$txtChangeBorn 		= isset($_POST['txtChangeBorn'])? trim($_POST['txtChangeBorn'])  : '';
		$txtChangeGender 	= isset($_POST['txtChangeGender'])? trim($_POST['txtChangeGender'])  : 1;
		
		$txtChangeYahoo = isset($_POST['txtChangeYahoo'])? trim($_POST['txtChangeYahoo'])  : '';
		$txtChangeSkyper = isset($_POST['txtChangeSkyper'])? trim($_POST['txtChangeSkyper'])  : '';
		$txtChangeIntro = isset($_POST['txtChangeIntro'])? trim($_POST['txtChangeIntro'])  : '';
		$txtFormInfoChange = isset($_POST['txtFormInfoChange'])? trim($_POST['txtFormInfoChange'])  : '';
		$txtChangeAddress = isset($_POST['txtChangeAddress'])? trim($_POST['txtChangeAddress'])  : '';
		
		$phone_ok = 0;
		if(preg_match("/^[0-9() -]+$/", $txtChangePhone)) {
		  if(strlen($txtChangePhone) >= 10 && strlen($txtChangePhone) <= 20){
		  	 $phone_ok = 1;
		  }else{
			drupal_set_message('Bạn vui lòng nhập đúng số điện thoại!');
			unset($_POST);
			drupal_goto($base_url.'/thay-doi-thong-tin-ca-nhan');
		  }
		}else{
			drupal_set_message('Bạn vui lòng nhập đúng số điện thoại!');
			unset($_POST);
			drupal_goto($base_url.'/thay-doi-thong-tin-ca-nhan');
		}
		
		if($txtFormInfoChange == 'txtFormInfoChange' && $txtChangePhone!='' && $txtChangeFullname!='' && $phone_ok==1 && $txtChangeAddress!=''){
			
			$data = array(
				'fullname'=>$txtChangeFullname,
				'phone'=>$txtChangePhone,
				'born'=>$txtChangeBorn,
				'gender'=>$txtChangeGender,
				'yahoo'=>$txtChangeYahoo,
				'skype'=>$txtChangeSkyper,
				'intro_user'=>$txtChangeIntro,
				'address'=>$txtChangeAddress
			);
			$clsUpload = new clsUpload();
			$current_path_img = $user->img;
			$name_img = $clsUpload->check_upload_file('txtChangeAvatar', $current_path_img, $name_module='profiles');
			if($name_img!=''){
				$data['img'] = $name_img;
			}
			//update user
			$clsUsers->updateOne($data, $user->uid);
			drupal_set_message('Bạn đã thay đổi thông tin cá nhân thành công.');
			drupal_goto($base_url.'/thay-doi-thong-tin-ca-nhan');
			
		}else{
			drupal_set_message('Bạn vui lòng nhập đầy đủ thông tin!');
			unset($_POST);
			drupal_goto($base_url.'/thay-doi-thong-tin-ca-nhan');
		}
	}
	$view = theme('change-user-info');
	return $view;
}
function change_pass_user(){
	global $base_url, $user;
	if($user->uid==0){
		drupal_goto($base_url.'/user');
		exit();
	}
	clsSeo::SEO($title='Thay đổi mật khẩu cá nhân', $img='', $meta_title='Thay đổi mật khẩu cá nhân', $meta_keyword='Thay đổi mật khẩu cá nhân', $meta_description='Thay đổi mật khẩu cá nhân');
	if(isset($_POST['txtFormChangePass'])){
		
		$clsUsers = new Users();
		$txtMail 	= isset($_POST['txtMail'])? trim($_POST['txtMail'])  : '';
		$txtPassNew 	= isset($_POST['txtPassNew']) 	? trim($_POST['txtPassNew'])  : '';
		$txtRePassNew 	= isset($_POST['txtRePassNew'])? trim($_POST['txtRePassNew'])  : '';
		$txtFormChangePass = isset($_POST['txtFormChangePass'])? trim($_POST['txtFormChangePass'])  : '';
		
		$regexEmail = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		if (!preg_match($regexEmail, $txtMail)) {
		     drupal_set_message("Email đăng nhập sai. Vui lòng thử lại");
			 unset($_POST);
			 drupal_goto($base_url.'/thay-doi-mat-khau');
		}else{
			//check email phu hop voi user
			$is_user = check_email_of_user($user->uid, $txtMail);
			if($is_user>0){
				if($txtPassNew!='' && strlen($txtPassNew)>=6 && $txtPassNew == $txtRePassNew && $txtFormChangePass=='txtFormChangePass'){
					require_once DRUPAL_ROOT . '/' . variable_get('password_inc', 'includes/password.inc');
					$editPassMd5 = user_hash_password(trim($txtPassNew));
					$data = array(
								'pass' => $editPassMd5,
							);
					//update password
					$clsUsers->updateByCond($data, "name",  $txtMail);
					drupal_set_message('Bạn đã thay đổi mật khẩu thành công. Vui lòng thoát và đăng nhập lại để kiểm tra!');
					drupal_goto($base_url.'/thay-doi-mat-khau');
				}
			}else{
				drupal_set_message('Bạn nhập thông tin chưa đúng!');
				unset($_POST);
				drupal_goto($base_url.'/thay-doi-mat-khau');
			}
		}
	}
	
	$view = theme('change-user-pass');
	return $view;
}
function check_email_of_user($uid, $mail){
	$clsUsers = new Users();
	if($uid > 0 && $mail!=''){
		$sql = $clsUsers->getByCond("uid", "uid = '".$uid."' AND name='".$mail."'");
		if(count($sql) > 0){
			return 1;
		}
	}
	return 0;
}