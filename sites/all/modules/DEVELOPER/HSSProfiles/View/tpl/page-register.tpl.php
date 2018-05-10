<?php
	global $base_url;
?>
<div class="page-register">
	<div class="register-user">
		<div class="header-register">
			<h2>Đăng ký thành viên</h2>
		</div>
		<form name="frm-register" method="POST" action="">
		<div class="info-register">
			<div class="note-register">Mời Quý vị đăng ký thành viên để đăng tin trên website BatDongSan86.vn!</div>
			<div class="line-register">
				<label>Email đăng nhập <span>(*)</span></label>
				<div class="line-content">
					<input type="text" id="frmMail" name="frmMail" maxlength="100" />
					<div class="error-message des des-mail">Địa chỉ email không được để trống.<br>
						Email đăng nhập phải có dạng<br/>vd:nguyenanh@batdongsan86.vn
					</div>
				</div>
			</div>
			<div class="line-register">
				<label>Mật khẩu <span>(*)</span></label>
				<div class="line-content">
					<input type="password" id="frmPass" name="frmPass" maxlength="100" />
					<div class="error-message des des-pass">Mật khẩu không được để trống.</div>
				</div>
			</div>
			<div class="line-register">
				<label>Nhập lại mật khẩu <span>(*)</span></label>
				<div class="line-content">
					<input type="password" id="frmRePass" name="frmRePass" maxlength="100" />
					<div class="error-message des des-repass">Xác thực mật khẩu không được để trống và phải trùng với mật khẩu ở trên.</div>
				</div>
			</div>
			<div class="line-register">
				<label>Tên đầy đủ <span>(*)</span></label>
				<div class="line-content">
					<input type="text" id="frmFullname" name="frmFullname" maxlength="250" />
					<div class="error-message des des-full-name">Tên đầy đủ không được để trống.</div>
				</div>
			</div>
			<div class="line-register">
				<label>Ngày sinh</label>
				<div class="line-content">
					<input type="text" id="frmBorn" name="frmBorn" maxlength="250" />
				</div>
			</div>
			<div class="line-register ext">
				<label>Giới tính</label>
				<div class="line-content">
					<input type="radio" id="gender1" class="txtRadio" value='1' name="frmGender" checked="checked"/>
					<label for="gender1"> Nam</label>
					<input type="radio" id="gender2" class="txtRadio" value='2' name="frmGender" />
					<label for="gender2"> Nữ</label>
				</div>
			</div>
			<div class="line-register">
				<label>Địa chỉ ở hiện tại <span>(*)</span></label>
				<div class="line-content">
					<input type="text" id="frmAddress" name="frmAddress" maxlength="250" />
					<div class="error-message des des-address">Địa chỉ ở hiện tại không được để trống.</div>
				</div>
			</div>
			<div class="line-register">
				<label>Điện thoại <span>(*)</span></label>
				<div class="line-content">
					<input type="text" id="frmPhone" name="frmPhone" maxlength="250" />
					<div class="error-message des des-phone">Số điện thoại không được để trống và phải là số.</div>
				</div>
			</div>
			<div class="line-register">
				<label>Yahoo IM</label>
				<div class="line-content">
					<input type="text" id="frmYahoo" name="frmYahoo" maxlength="250" />
				</div>
			</div>
			<div class="line-register">
				<label>Skype</label>
				<div class="line-content">
					<input type="text" id="frmSkype" name="frmSkype" maxlength="250" />
				</div>
			</div>
			<div class="line-register">
				<label>Giới thiệu chung</label>
				<div class="line-content">
					<textarea name="frmIntro" id="frmIntro" cols="30" rows="10"></textarea>
				</div>
			</div>
			<!--<div class="line-register showCaptcha">
				<label>Nhập mã bảo vệ: <span>(*)</span></label>
				<div class="line-content">				
					<input id="security_code" name="security_code" type="text"/>
					<img id="img_code" src="<?php echo $base_url?>/captcha?rand=<?php echo rand();?>" />
					<span id="refresh_code" onclick="refreshCaptcha();" title="Refresh captcha">new captcha</span>
					<div class="error-message des captchaError">Phải nhập đúng captcha.</div>
				</div>
			</div>-->
			<div class="textNoteStrong">Chúng tôi sẽ gửi đến hộp thư của bạn 1 email xác nhận đăng ký thành viên sau khi đăng ký thành viên hoàn tất.</div>
			<div class="line-register center">
				<input  type="hidden" name="dologin" id="dologin" class="dologin" value="dologin"/>
				<input type="submit" class="button-register" id="frmSubmitRegister" value="Đăng ký" name="btnRegister">
			</div>
		</div>
		</form>
	</div>
</div>