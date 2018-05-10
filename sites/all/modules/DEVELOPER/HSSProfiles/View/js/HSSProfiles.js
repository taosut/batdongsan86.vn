jQuery(document).ready(function($){
	REGISTER.init();
	CONFIG_DATE.init();
	CONFIG_DATE.element('#frmBorn');
	CHANGE_INFO.pass();
    CHANGE_INFO.info();

    POST_ESTATE.post();
    POST_ESTATE.del();
});
REGISTER = {
	init:function(){
		jQuery("#frmBorn").datepicker();
		jQuery('#frmSubmitRegister').click(function(){
			var valid = true;
			var frmAgree = jQuery('#frmAgree').attr('checked') ? 1 : 0;
		
			if(jQuery('#frmMail').val() == ''){
				jQuery('#frmMail').addClass('error');
				jQuery(".des-mail").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#frmMail').removeClass('error');
				jQuery(".des-mail").removeClass('show-error');	
			}
			/*check email*/
			var email =jQuery('#frmMail').val();
			if(!email.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/)){
				jQuery('#frmMail').addClass('error');
				jQuery(".des-mail").addClass('show-error');
				valid = false;
			}else{
				jQuery('#frmMail').removeClass('error');
				jQuery(".des-mail").removeClass('show-error');
			}
		
			if(jQuery('#frmPass').val() == '' || jQuery('#frmPass').val().length < 6){
				jQuery('#frmPass').addClass('error');
				jQuery(".des-pass").addClass('show-error');
				valid = false;
			}else{
				jQuery('#frmPass').removeClass('error');
				jQuery(".des-pass").removeClass('show-error');
			}
			
			if(jQuery('#frmPass').val() != jQuery('#frmRePass').val()){
				jQuery('#frmRePass').addClass('error');
				jQuery(".des-repass").addClass('show-error');
				valid = false;
			}else{
				jQuery('#frmRePass').removeClass('error');
				jQuery(".des-repass").removeClass('show-error');
			}

			if(jQuery('#frmPhone').val() == ''){
				jQuery('#frmPhone').addClass('error');
				jQuery(".des-phone").addClass('show-error');
				valid = false;
			}else{
				var regex = /^[0-9-+]+$/;
				var phone = jQuery('#frmPhone').val();
				if (regex.test(phone)){
					if(jQuery('#frmPhone').val().length>=9 && jQuery('#frmPhone').val().length<=20){
						jQuery('#frmPhone').removeClass('error');
						jQuery(".des-phone").removeClass('show-error');
					}else{
						jQuery('#frmPhone').addClass('error');
						jQuery(".des-phone").addClass('show-error');
						valid = false;
					}
			    }else{
					jQuery('#frmPhone').addClass('error');
					jQuery(".des-phone").addClass('show-error');
					valid = false;	
				}
			}
			
			if(jQuery('#frmAddress').val() == ''){
				jQuery('#frmAddress').addClass('error');
				jQuery(".des-address").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#frmAddress').removeClass('error');
				jQuery(".des-address").removeClass('show-error');	
			}
			
			if(jQuery('#frmFullname').val() == ''){
				jQuery('#frmFullname').addClass('error');
				jQuery(".des-full-name").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#frmFullname').removeClass('error');
				jQuery(".des-full-name").removeClass('show-error');	
			}
			/*
			if(jQuery('input#security_code').val()==''){
				jQuery('input#security_code').addClass('error');
				jQuery(".captchaError").addClass('show-error');
				valid = false;
			}else{
				var code = jQuery('input#security_code').val();
				var domain = BASEPARAMS.base_url;
				var urlcode = domain + '/captcha/'+code;
				jQuery.ajax({
					type: "POST",
					url: urlcode,
					data: "code=" + encodeURI(code),
					success: function(html){
						if(html=='0'){
							jQuery('input#security_code').addClass('error');
							jQuery('.captchaError').addClass('show-error');
							valid = false;
						}else{
							jQuery('input#security_code').removeClass('error');
							jQuery('.captchaError').removeClass('show-error');
						}
					}
				});
			}
			*/
			return valid;
		});
	}
}
CHANGE_INFO = {
	pass:function(){
		jQuery("#frmSubmitChangPass").click(function(){
			var valid = true;
			var txtMail = jQuery("#txtMail").val();
			var txtPassNew = jQuery("#txtPassNew").val();
			var txtRePassNew = jQuery("#txtRePassNew").val();
			
			if(txtMail == ''){
				jQuery('#txtMail').addClass('error');
				jQuery(".mail-login").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#txtMail').removeClass('error');
				jQuery(".mail-login").removeClass('show-error');
			}
			
			if(!txtMail.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/)){
				jQuery('#txtMail').addClass('error');
				jQuery(".mail-login").addClass('show-error');
				valid = false;
			}else{
				jQuery('#txtMail').removeClass('error');
				jQuery(".mail-login").removeClass('show-error');
			}
			
			if(txtPassNew == '' || jQuery('#txtPassNew').val().length < 6){
				jQuery('#txtPassNew').addClass('error');
				jQuery(".pass-new").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#txtPassNew').removeClass('error');
				jQuery(".pass-new").removeClass('show-error');
			}
			
			if(txtPassNew != txtRePassNew){
				jQuery('#txtRePassNew').addClass('error');
				jQuery(".repass-new").addClass('show-error');
				valid = false;
			}else{
				jQuery('#txtRePassNew').removeClass('error');
				jQuery(".repass-new").removeClass('show-error');
			}
			
			return valid;
		});
	},
	info:function(){
		jQuery("#txtChangeBorn").datepicker();
		jQuery("#frmSubmitChangInfo").click(function(){
			var valid = true;
			var txtChangeFullname = jQuery("#txtChangeFullname").val();
			var txtChangePhone = jQuery("#txtChangePhone").val();
			if(txtChangeFullname == ''){
				jQuery('#txtChangeFullname').addClass('error');
				jQuery(".des-name").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#txtChangeFullname').removeClass('error');
				jQuery(".des-name").removeClass('show-error');
			}
			if(txtChangePhone == ''){
				jQuery('#txtChangePhone').addClass('error');
				jQuery(".des-phone").addClass('show-error');	
				valid = false;
			}else{
				var regex = /^[0-9-+]+$/;
				if (regex.test(txtChangePhone)) {
					if(jQuery("#txtChangePhone").val().length>=9 && jQuery("#txtChangePhone").val().length<=20){
						jQuery('#txtChangePhone').removeClass('error');
						jQuery(".des-phone").removeClass('show-error');
					}else{
						jQuery('#txtChangePhone').addClass('error');
						jQuery(".des-phone").addClass('show-error');
						valid = false;
					}
			    }else{
					jQuery('#txtChangePhone').addClass('error');
					jQuery(".des-phone").addClass('show-error');
					valid = false;
				}	
			}
			if(jQuery('#txtChangeAddress').val() == ''){
					jQuery('#txtChangeAddress').addClass('error');
					jQuery(".des-address").addClass('show-error');	
					valid = false;
				}else{
					jQuery('#txtChangeAddress').removeClass('error');
					jQuery(".des-address").removeClass('show-error');	
				}
			
			return valid;
		});
	}
}
CONFIG_DATE = {
	init:function(){
		jQuery.datepicker.regional['vi'] = {
					closeText: 'Đóng',
					prevText: '&#x3c;Trước',
					nextText: 'Tiếp&#x3e;',
					currentText: 'Hôm nay',
					monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
					'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai'],
					monthNamesShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
					'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
					dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
					dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
					dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
					weekHeader: 'Tu',
					dateFormat: 'dd/mm/yy',
					firstDay: 0,
					isRTL: false,
					showMonthAfterYear: false,
					yearSuffix: ''
		};
		jQuery.datepicker.setDefaults(jQuery.datepicker.regional['vi']); 
	},
	element:function(element){
		jQuery(element).datepicker();
	},
}
POST_ESTATE = {
	post:function(){
		if(jQuery('#frmProvice').val()>0){
			var txtProviceId = jQuery('#frmProvice').val()
			var txtDicttrictID = jQuery(".dictrictid").text();
			var domain = BASEPARAMS.base_url;
			var url = domain + '/danh-sach-quan-huyen';
			jQuery.ajax({
				type: "POST",
				url: url,
				data: "txtProviceId=" + encodeURI(txtProviceId) + "&txtDicttrictID=" + encodeURI(txtDicttrictID),
				success: function(data){
					jQuery("#frmDistrict").html(data);
				}
			});
		}
		
		jQuery('#frmProvice').change(function(){
			var txtProviceId = jQuery('#frmProvice').val();
			if(txtProviceId == 0){
				jQuery("#frmDistrict").html('<option value="0">--Quận/Huyện--</option>');
			}else{
				var domain = BASEPARAMS.base_url;
				var url = domain + '/danh-sach-quan-huyen';
				jQuery.ajax({
					type: "POST",
					url: url,
					data: "txtProviceId=" + encodeURI(txtProviceId),
					success: function(data){
						jQuery("#frmDistrict").html(data);
					}
				});
			}
		});
		
		jQuery('#frmUnit').change(function(){
			var unit = jQuery('#frmUnit option:selected').text();
			var area = jQuery('#frmArea').val();
			var price = jQuery('#frmPrice').val();
			
			if(jQuery('#frmUnit').val()>0 && area!='' && area>=0 && price!='' && price>=0){
				if(parseFloat(area)!='NaN' && parseFloat(price)!='NaN'){
					var total_price = parseFloat(parseFloat(area)*parseFloat(price));
					total_price = total_price.toFixed(3);
					total_price = FORMAT_NUMBER.formatNumber(total_price);
					jQuery("span#priceTotal").text(total_price+' '+unit);
				}
				
			}else{
				jQuery("span#priceTotal").text('');
			}
		});
		
		jQuery("#frmSubmitEstate").click(function(){
			var valid = true;
			var frmTitle = jQuery("#frmTitle").val();
            var frmContent = jQuery("#frmContent").val();
			var frmSubCatid = jQuery("#frmSubCatid").val();
			var frmProvice = jQuery("#frmProvice").val();
			var frmDistrict = jQuery("#frmDistrict").val();
			var frmAddressMore = jQuery("#frmAddressMore").val();
			var frmContactPhone = jQuery("#frmContactPhone").val();
			var security_code = jQuery("#security_code").val();
			var frmContactMail = jQuery("#frmContactMail").val();
			
			
			if(frmTitle == '' || jQuery('#frmTitle').val().length > 255 || jQuery('#frmTitle').val().length < 20){
				jQuery('#frmTitle').addClass('error');
				jQuery(".title-post").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#frmTitle').removeClass('error');
				jQuery(".title-post").removeClass('show-error');
			}
			
			if(frmContent == ''|| frmContent.length<50 || frmContent.length>3000){
				jQuery('#frmContent').addClass('error');
				jQuery(".content-post").addClass('show-error');
			}else{
				jQuery('#frmContent').removeClass('error');
				jQuery(".content-post").removeClass('show-error');
			}
			
			if(frmSubCatid==0){
				jQuery('#frmSubCatid').addClass('error');
				jQuery(".subcatid-post").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#frmSubCatid').removeClass('error');
				jQuery(".subcatid-post").removeClass('show-error');
			}
			
			if(frmProvice==0){
				jQuery('#frmProvice').addClass('error');
				jQuery(".provice-post").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#frmProvice').removeClass('error');
				jQuery(".provice-post").removeClass('show-error');
			}
			
			if(frmDistrict==0){
				jQuery('#frmDistrict').addClass('error');
				jQuery(".district-post").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#frmDistrict').removeClass('error');
				jQuery(".district-post").removeClass('show-error');
			}
			
			if(frmAddressMore == ''){
				jQuery('#frmAddressMore').addClass('error');
				jQuery(".address-more-post").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#frmAddressMore').removeClass('error');
				jQuery(".address-more-post").removeClass('show-error');
			}
			
			if(frmAddressMore == ''){
				jQuery('#frmAddressMore').addClass('error');
				jQuery(".address-more-post").addClass('show-error');	
				valid = false;
			}else{
				jQuery('#frmAddressMore').removeClass('error');
				jQuery(".address-more-post").removeClass('show-error');
			}
			
			if(frmContactPhone == ''){
				jQuery('#frmContactPhone').addClass('error');
				jQuery(".phone-contact-post").addClass('show-error');	
				valid = false;
			}else{
				var regex = /^[0-9-+]+$/;
				var phone = jQuery('#frmContactPhone').val();
				if(regex.test(phone)) {
					if(jQuery('#frmContactPhone').val().length>=9 && jQuery('#frmContactPhone').val().length<=20){
						jQuery('#frmContactPhone').removeClass('error');
						jQuery(".phone-contact-post").removeClass('show-error');
					}else{
						jQuery('#frmContactPhone').addClass('error');
						jQuery(".phone-contact-post").addClass('show-error');
						valid = false;
					}
					
			    }else{
					jQuery('#frmContactPhone').addClass('error');
					jQuery(".phone-contact-post").addClass('show-error');
					valid = false;	
				}
			}
			
			if(frmContactMail!=''){
				if(!frmContactMail.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/)){
					jQuery('#frmContactMail').addClass('error');
					jQuery(".mail-contact-post").addClass('show-error');
					valid = false;
				}else{
					jQuery('#frmContactMail').removeClass('error');
					jQuery(".mail-contact-post").removeClass('show-error');
				}
			}else{
				jQuery('#frmContactMail').removeClass('error');
				jQuery(".mail-contact-post").removeClass('show-error');
			}
			
			return valid;
		});
		
	},
	
	del:function(){
		jQuery(".delItemEstates").click(function(){
			var idItem = jQuery(this).attr('dataid');
			jConfirm('Bạn có muốn xóa không [OK]:Yes[Cancel]:No?', 'Xác nhận', function(r) {
				if(r){
					window.location.href = BASEPARAMS.base_url+"/xoa-tin-dang/"+idItem;
				}
			});
		});
	}
	
}