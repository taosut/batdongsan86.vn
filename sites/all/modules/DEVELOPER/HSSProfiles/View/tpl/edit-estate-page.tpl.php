<?php 
	global $base_url;
?>
<script type="text/javascript" src="<?php echo $base_url?>/sites/all/modules/DEVELOPER/HSSProfiles/View/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo $base_url?>/sites/all/modules/DEVELOPER/HSSProfiles/View/js/tiny_mce/tinycustom.js"></script>
<div class="main-post-estate ">
	<div class="wrap-main-post-estate">
		<h2>Sửa tin đăng</h2>
		<div class="box-post-content-estate">
			<div class="box-post-estate-left">
				<form name="frmPostEstate" id="frmPostEstate" method="POST" action="" enctype="multipart/form-data">
					<?php foreach ($getItem as $v) {?>
					<div class="item-post-frm">
						<label>Tiêu đề tin đăng <span>*</span></label>
						<input  type="text" name="frmTitle" id="frmTitle" class="frm-ext-long" maxlength="255" value="<?php echo $v->title ?>"/>
						<!--<span class="count-title-char"><span id="count-title">0</span>/255</span>-->
						<span class="des title-post">Vui lòng nhập tiêu đề của tin đăng tối thiểu 20 ký tự, tối đa là 255 ký tự.</span>
					</div>
					<div class="box-info-frm-post">
						<div class="title-intro">Thông tin mô tả</div>
						<div class="content-intro">
							<label>Nội dung tin đăng <span>*</span> <span><!--<span id="count-content">0</span>/3000</span>--></label>
							<textarea name="frmContent" id="frmContent" maxlength="3000"><?php echo $v->content ?></textarea>
							<span class="des content-post">Vui lòng nhập nội dung của tin đăng lớn hơn 50 ký tự và nhỏ hơn 3000 ký tự.</span>
							<div class="img-box">
								<input type="file" name="frmImage" id="frmImage" class="frmImage"/> <i>Tệp ảnh tối đa 5Mb</i>
								<div class="img-item">
								<?php 
								$img='';
								if($v->img!=''){
									$img = "estates/".$v->img;
									}else{
										$img = "default.jpg";
									}
									$img = modThumbBase( $img, 200, 200, $alt="$v->title", true, 100, false, "" );
									echo $img;
								?>
							</div>	
							</div>
							<div class="img-box">
								<span class="insert-box" id="insert-video">Video nhà đất</span> <i>Liên hệ với chúng tôi để được hỗ trợ</i>
							</div>
						</div>
					</div>
					<div class="box-info-frm-post">
						<div class="title-intro">Thông tin cơ bản</div>
						<div class="content-intro ext-box-basic">
							<div class="item-post-basic catid">
								<label>Hình thức<span>*</span></label>
								<select name="frmSubCatid" id="frmSubCatid">
									<?php foreach($arrOptionsCategory as $key=>$val){?>
										<option value="<?php echo $key ?>" <?php if($key == $v->catid){?>selected="selected"<?php } ?>><?php echo $val ?></option>
									<?php } ?>
								</select>
								<span class="des catid-post">Vui lòng chọn loại bất động sản.</span>
							</div>
							<div class="item-post-basic proviceid">
								<label>Tỉnh/Thành phố<span>*</span></label>
								<select name="frmProvice" id="frmProvice">
									<option value="0">--Tỉnh/Thành phố--</option>
									<?php 
										$arrProvice = $clsProvices->list_category($v->provice);
										echo $arrProvice 
									?>
								</select>
								<span class="des provice-post">Vui lòng chọn tỉnh/thành phố.</span>
							</div>
							<div class="item-post-basic districtid">
								<label>Quận/Huyện<span>*</span></label>
								<span style="display:none" class="dictrictid"><?php echo $v->dictrict?></span>
								<select name="frmDistrict" id="frmDistrict">
									<option value="0">--Quận/Huyện--</option>
								</select>
								<span class="des district-post">Vui lòng chọn quận/huyện.</span>
							</div>
							<div class="item-post-basic ext-address">
								<label>Địa chỉ<span>*</span></label>
								<input  type="text" name="frmAddressMore" id="frmAddressMore" class="frm-ext-long" value="<?php echo $v->address_more ?>"/>
								<span class="des address-more-post">Vui lòng nhập địa chỉ chi tiết của bất động sản.</span>
							</div>
							<div class="item-post-basic">
								<label>Điện tích</label>
								<input type="text" name="frmArea" id="frmArea" value="<?php echo $v->area ?>"/>
							</div>
							<div class="item-post-basic">
								<label>Giá</label>
								<input type="text" name="frmPrice" id="frmPrice" value="<?php echo $v->price ?>"/>
							</div>
							<div class="item-post-basic">
								<label>Đơn vị giá</label>
								<select name="frmUnit" id="frmUnit">
									<option value="0">--Chọn đơn vị--</option>
									<?php 
										$type_id = 5;
										$arrUnit = $clsCategory->list_category($v->unit, $type_id);
										echo $arrUnit;
									 ?>
								</select>
							</div>
							<!--<div class="item-post-basic total-price">Tổng tiền: <span class="num-total" id="priceTotal"></span></div>-->
						</div>
					</div>
					<div class="box-info-frm-post">
						<div class="title-intro">Thông tin liên hệ</div>
						<div class="content-intro">
							<div class="item-post-contact">
								<label>Tên liên hệ</label>
								<input type="text" name="frmContactName" id="frmContactName" class="frm-ext-long" value="<?php echo $v->contact ?>"/>
							</div>
							<div class="item-post-contact">
								<label>Địa chỉ</label>
								<input  type="text" name="frmContactAddress" id="frmContactAddress" class="frm-ext-long" value="<?php echo $v->address ?>"/>
							</div>
							<div class="item-post-contact">
								<label>Điện thoại<span>*</span></label>
								<input  type="text" name="frmContactPhone" id="frmContactPhone" class="frm-ext-short" value="<?php echo $v->phone ?>"/>
								<span class="des phone-contact-post">Vui lòng nhập điện thoại liên hệ.</span>
							</div>
							<div class="item-post-contact">
								<label>Email</label>
								<input  type="text" name="frmContactMail" id="frmContactMail" class="frm-ext-short" value="<?php echo $v->mail ?>"/>
								<span class="des mail-contact-post">Vui lòng nhập đúng định dạng email.<br/>Vd: nguyenanh@batdongsanhungvuong.com</span>
							</div>
						</div>
					</div>
					<!--<div class="item-post-frm showCaptcha">
						<label for='message'>Nhập mã bảo vệ: <span>*</span></label>
						<input id="security_code" name="security_code" type="text"/>
						<img id="img_code" src="<?php echo $base_url?>/captcha?rand=<?php echo rand();?>" />
						<span id="refresh_code" onclick="refreshCaptcha();" title="Refresh captcha">new captcha</span>
						<span class="des captcha-post">Phải nhập đúng captcha.</span>
					</div>-->
					<div class="item-post-frm button">
						<input type="hidden" name="txtFormNameEstate" id="txtFormNameEstate" value="txtFormNameEstate"/>
						<input  type="submit" id="frmSubmitEstate" value="Cập nhật tin" />
					</div>
					<?php } ?>
				</form>
			</div>
			<div class="box-post-estate-right">
				<div class="item-main-right">
					<div class="title-item-main-right">
						<span>Qui định về đăng tin</span>
					</div>
					<div class="content-post-items-right-box">
						<div class="wrapp-content-post-items-right-box">
							<ul>
								<li>Thông tin có dấu (<span style="color:#ff0000">*</span>) là bắt buộc.</li>
								<li>Không đăng lại tin đã đăng trên batdongsan86.vn</li>
								<li>Không gộp nhiều bất động sản trong một tin đăng.</li>
								<li>Không đặt nhiều link-liên kết trong tin đăng.</li>
								<li>Tin đăng phải là tiếng Việt có dấu.</li>
								<li>Tin đăng không đúng qui định sẽ bị ban quản trị xóa mà không cần thông báo trước.</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>