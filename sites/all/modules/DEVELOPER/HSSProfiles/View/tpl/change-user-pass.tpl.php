<?php
	global $base_url;
?>
<div class="page-register">
	<div class="register-user">
		<div class="header-register">
			<h2>Thay đổi mật khẩu</h2>
		</div>
		<form name="frm-register" method="POST" action="">
		<div class="info-register">
			<div class="line-register">
				<label>Email đăng nhập <span>(*)</span></label>
				<div class="line-content">
					<input  type="text" name="txtMail" id="txtMail" class="txtItem"/>
					<div class="error-message des mail-login">Vui lòng nhập email đăng nhập.
					</div>
				</div>
			</div>
			<div class="line-register">
				<label>Mật khẩu mới<span>(*)</span></label>
				<div class="line-content">
					<input  type="password" name="txtPassNew" id="txtPassNew" class="txtItem"/>
					<div class="error-message des pass-new">Mật khẩu không được để trống.</div>
				</div>
			</div>
			<div class="line-register">
				<label>Nhập lại mật khẩu <span>(*)</span></label>
				<div class="line-content">
					<input  type="password" name="txtRePassNew" id="txtRePassNew" class="txtItem"/>
					<div class="error-message des repass-new">Mật khẩu mới không khớp.</div>
				</div>
			</div>
			<div class="line-register center">
				<input type="hidden" name="txtFormChangePass" id="txtFormChangePass" value="txtFormChangePass"/>
				<input  type="submit" class="button-register" id="frmSubmitChangPass" value="Lưu" />
			</div>
		</div>
		</form>
	</div>
</div>