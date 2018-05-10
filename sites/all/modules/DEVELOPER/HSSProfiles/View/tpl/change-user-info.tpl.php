<?php 
	global $base_url, $user;
?>
<div class="page-register">
	<div class="register-user">
		<div class="header-register-change">
			<h2>Thay đổi thông tin cá nhân</h2>
		</div>
		<form name="frm-register" method="POST" action="" enctype="multipart/form-data">
		<div class="info-register">
			<div class="line-register">
				<label>Tên đầy đủ <span>(*)</span></label>
				<div class="line-content">
					<input type="text" name="txtChangeFullname" id="txtChangeFullname" class="txtItem" value="<?php echo $user->fullname ?>"/>
					<div class="error-message des des-name">Vui lòng nhập tên của bạn.</div>
				</div>
			</div>
			<div class="line-register">
				<label>Điện thoại <span>(*)</span></label>
				<div class="line-content">
					<input  type="text" name="txtChangePhone" id="txtChangePhone" class="txtItem" value="<?php echo $user->phone ?>"/>
					<div class="error-message des des-phone">Vui lòng nhập số điện thoại của bạn.</div>
				</div>
			</div>
			<div class="line-register">
				<label>Địa chỉ <span>(*)</span></label>
				<div class="line-content">
					<input type="text" id="txtChangeAddress" name="txtChangeAddress" value="<?php echo $user->address?>">
					<div class="error-message des des-address">Địa chỉ không được trống.</div>
				</div>
			</div>
			<div class="line-register">
				<label>Ngày sinh</label>
				<div class="line-content">
					<input type="text" name="txtChangeBorn" id="txtChangeBorn" class="txtItem"  value="<?php echo $user->born ?>"/>
				</div>
			</div>
			<div class="line-register ext">
				<label>Giới tính</label>
				<div class="line-content">
					<input type="radio" id="gender1" class="txtRadio" value='1' name="txtChangeGender" <?php if($user->gender==1){?> checked="checked" <?php } ?>/>
					<label for="gender1"> Nam</label>
					<input type="radio" id="gender2" class="txtRadio" value='2' name="txtChangeGender" <?php if($user->gender==2){?> checked="checked" <?php } ?>/>
					<label for="gender2"> Nữ</label>
				</div>
			</div>			
			<div class="line-register">
				<label>Yahoo IM</label>
				<div class="line-content">
					<input  type="text" name="txtChangeYahoo" id="txtChangeYahoo" class="txtItem" value="<?php echo $user->yahoo ?>"/>
				</div>
			</div>
			<div class="line-register">
				<label>Skype</label>
				<div class="line-content">
					<input  type="text" name="txtChangeSkyper" id="txtChangeSkyper" class="txtItem" value="<?php echo $user->skype ?>"/>
				</div>
			</div>
			<div class="line-register">
				<label>Giới thiệu chung</label>
				<div class="line-content">
					<textarea name="txtChangeIntro" id="txtChangeIntro" class="txtTextArea" cols="30" rows="10"><?php echo $user->intro_user ?></textarea>
				</div>
			</div>
			<div class="line-register">
				<label>Ảnh</label>
				<div class="line-content">
					<input type="file" name="txtChangeAvatar" id="txtChangeAvatar"/>
				</div>
			</div>
			<div class="line-register">
				<label>&nbsp;</label>
				<div class="line-content">
					<?php 
						$img='';
						if($user->img!=''){
							$img = "profiles/".$user->img;
						}else{
							if($user->gender==1){
								echo '<img src="'.$base_url.'/'.path_to_theme().'/View/img/no-avatar-men.jpg" alt="">';
							}else{
								echo '<img src="'.$base_url.'/'.path_to_theme().'/View/img/no-avatar-girl.jpg" alt="">';
							}
						}
						$img = modThumbBase( $img, 150, 150, $alt="$user->fullname", true, 100, false, "" );
						echo $img;
					?>
				</div>
			</div>
			<div class="line-register center">
				<input type="hidden" name="txtFormInfoChange" id="txtFormInfoChange" value="txtFormInfoChange"/>
				<input  type="submit" id="frmSubmitChangInfo" value="Lưu"  class="button-register"/>
			</div>
		</div>
		</form>
	</div>
</div>