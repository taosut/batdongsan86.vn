jQuery(document).ready(function($){
  BACK_TOP.init();
  BOOKMARKS.init();
  SEARCH.header();
});

BACK_TOP={
	init:function(){
		 jQuery(window).scroll(function() {
            if(jQuery(window).scrollTop() > 0) {
				jQuery("div#back-top-wrapper").fadeIn();
			} else {
				jQuery("div#back-top-wrapper").fadeOut();
			}
		});

		jQuery("div#back-top-wrapper, .gotop").click(function(){
			jQuery("html, body").animate({scrollTop: 0}, 1000);
			return false;
		});
	}
}
BOOKMARKS={
	init:function(){
		jQuery(".set-home").click(function(e){
			e.preventDefault();
			var title = document.title;
        	var url = document.location.href;
			alert("Nhấn CTRL+D và click link để bookmark!", "");
		});
	}	
}

SEARCH = {
	header:function(){
		jQuery('.btn-search').click(function(){
			var txtKeyword = jQuery('#txtKeyword').val();
			if(txtKeyword == ''){
				jQuery('.txtKeyword').focus();
				return false;
			}
		})
	}
};
function refreshCaptcha(){
	var img = document.images['img_code'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.round(1000*Math.random());
};
// jQuery Alert Dialogs Plugin
//
// Version 1.1
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 14 May 2009
//
// Website: http://abeautifulsite.net/blog/2008/12/jquery-alert-dialogs/
//
// Usage:
//		jAlert( message, [title, callback] )
//		jConfirm( message, [title, callback] )
//		jPrompt( message, [value, title, callback] )
//
// History:
//
//		1.00 - Released (29 December 2008)
//
//		1.01 - Fixed bug where unbinding would destroy all resize events
//
// License:
//
// This plugin is dual-licensed under the GNU General Public License and the MIT License and
// is copyright 2008 A Beautiful Site, LLC.
//
(function($) {

	$.alerts = {

		// These properties can be read/written by accessing $.alerts.propertyName from your scripts at any time

		verticalOffset: -75,                // vertical offset of the dialog from center screen, in pixels
		horizontalOffset: 0,                // horizontal offset of the dialog from center screen, in pixels/
		repositionOnResize: true,           // re-centers the dialog on window resize
		overlayOpacity: .5,                // transparency level of overlay
		overlayColor: '#C0C0C0',               // base color of overlay
		draggable: true,                    // make the dialogs draggable (requires UI Draggables plugin)
		okButton: '&nbsp;OK&nbsp;',         // text for the OK button
		cancelButton: '&nbsp;Cancel&nbsp;', // text for the Cancel button
		dialogClass: null,                  // if specified, this class will be applied to all dialogs

		// Public methods

		alert: function(message, title, callback) {
			if( title == null ) title = 'Alert';
			$.alerts._show(title, message, null, 'alert', function(result) {
				if( callback ) callback(result);
			});
		},

		confirm: function(message, title, callback) {
			if( title == null ) title = 'Confirm';
			$.alerts._show(title, message, null, 'confirm', function(result) {
				if( callback ) callback(result);
			});
		},

		prompt: function(message, value, title, callback) {
			if( title == null ) title = 'Prompt';
			$.alerts._show(title, message, value, 'prompt', function(result) {
				if( callback ) callback(result);
			});
		},

		// Private methods

		_show: function(title, msg, value, type, callback) {

			$.alerts._hide();
			$.alerts._overlay('show');

			$("BODY").append(
			  '<div id="popup_container">' +
			    '<h1 id="popup_title"></h1>' +
			    '<div id="popup_content">' +
			      '<div id="popup_message"></div>' +
				'</div>' +
			  '</div>');

			if( $.alerts.dialogClass ) $("#popup_container").addClass($.alerts.dialogClass);

			// IE6 Fix
			//var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed';
			var pos = 'fixed';
			$("#popup_container").css({
				position: pos,
				zIndex: 99999,
				padding: 0,
				margin: 0
			});

			$("#popup_title").text(title);
			$("#popup_content").addClass(type);
			$("#popup_message").text(msg);
			$("#popup_message").html( $("#popup_message").text().replace(/\n/g, '<br />') );

			$("#popup_container").css({
				minWidth: $("#popup_container").outerWidth(),
				maxWidth: $("#popup_container").outerWidth()
			});

			$.alerts._reposition();
			$.alerts._maintainPosition(true);

			switch( type ) {
				case 'alert':
					$("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /></div>');
					$("#popup_ok").click( function() {
						$.alerts._hide();
						callback(true);
					});
					$("#popup_ok").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
					});
				break;
				case 'confirm':
					$("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_ok").click( function() {
						$.alerts._hide();
						if( callback ) callback(true);
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback(false);
					});
					$("#popup_ok").focus();
					$("#popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
				break;
				case 'prompt':
					$("#popup_message").append('<br /><input type="text" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						var val = $("#popup_prompt").val();
						$.alerts._hide();
						if( callback ) callback( val );
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback( null );
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value ) $("#popup_prompt").val(value);
					$("#popup_prompt").focus().select();
				break;
			}

			// Make draggable
			if( $.alerts.draggable ) {
				try {
					$("#popup_container").draggable({ handle: $("#popup_title") });
					$("#popup_title").css({ cursor: 'move' });
				} catch(e) { /* requires jQuery UI draggables */ }
			}
		},

		_hide: function() {
			$("#popup_container").remove();
			$.alerts._overlay('hide');
			$.alerts._maintainPosition(false);
		},

		_overlay: function(status) {
			switch( status ) {
				case 'show':
					$.alerts._overlay('hide');
					$("BODY").append('<div id="popup_overlay"></div>');
					$("#popup_overlay").css({
						position: 'absolute',
						zIndex: 99998,
						top: '0px',
						left: '0px',
						width: '100%',
						height: $(document).height(),
						background: $.alerts.overlayColor,
						opacity: $.alerts.overlayOpacity
					});
				break;
				case 'hide':
					$("#popup_overlay").remove();
				break;
			}
		},

		_reposition: function() {
			var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + $.alerts.horizontalOffset;
			if( top < 0 ) top = 0;
			if( left < 0 ) left = 0;

			// IE6 fix
			//if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();

			$("#popup_container").css({
				top: top + 'px',
				left: left + 'px'
			});
			$("#popup_overlay").height( $(document).height() );
		},

		_maintainPosition: function(status) {
			if( $.alerts.repositionOnResize ) {
				switch(status) {
					case true:
						$(window).bind('resize', $.alerts._reposition);
					break;
					case false:
						$(window).unbind('resize', $.alerts._reposition);
					break;
				}
			}
		}

	}

	// Shortuct functions
	jAlert = function(message, title, callback) {
		$.alerts.alert(message, title, callback);
	}

	jConfirm = function(message, title, callback) {
		$.alerts.confirm(message, title, callback);
	};

	jPrompt = function(message, value, title, callback) {
		$.alerts.prompt(message, value, title, callback);
	};

})(jQuery);;
jQuery(document).ready(function($){
	
});;
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
	
};
(function($) {
	Drupal.behaviors.HSSPopupMessages = {
		attach: function (context) {
			var HSSPopupMessages = Drupal.settings.HSSPopupMessages; 
			var message_box = $('#pop-messages-wrapper');
			/* jQuery UI Enhancements */
			if (HSSPopupMessages.jquery_ui != null) {
				if (HSSPopupMessages.jquery_ui.draggable == '1') { message_box.draggable(); }
			}
			
			/* Popup Message handling */
			if (!message_box.hasClass("pop-messeges-processed")) {			
				/* Functions to determine the popin/popout animation */
				HSSPopupMessages.open = function() {
					switch (HSSPopupMessages.popin.effect) {
						case 'fadeIn': message_box.fadeIn(HSSPopupMessages.popin.duration);
							break;
						case 'slideDown': message_box.slideDown(HSSPopupMessages.popin.duration);
							break;
						default: message_box.fadeIn(HSSPopupMessages.popin.duration);
							break;
					}
				}
				HSSPopupMessages.close = function() {
					$('.simplemodal-overlay').css('display','none');
					switch (HSSPopupMessages.popout.effect) {
						case 'fadeOut':	message_box.fadeOut(HSSPopupMessages.popout.duration);
							break;
						case 'slideUp':	message_box.slideUp(HSSPopupMessages.popout.duration);
							break;
						default: message_box.fadeOut(HSSPopupMessages.popout.duration);
							break;
					}
					message_box.addClass("pop-messeges-processed");
				}
				/* Function to determine closing count */
				HSSPopupMessages.countDownClose = function(seconds) {
					if(seconds > 0) {
						seconds--;
						if (HSSPopupMessages.show_countdown == '1') {
							$('.message-timer').text(Drupal.t('Closing in' + ' ' + seconds + ' ' + Drupal.t('seconds')));
						}
			      if(seconds > 0) {
			      	HSSPopupMessages.countDown = setTimeout( function() {HSSPopupMessages.countDownClose(seconds);}, 1000 );
			      }
			      else {
							HSSPopupMessages.close();
						}
					}
				}
			
			$('<div></div>')
				.addClass('simplemodal-overlay')
				.css($.extend({}, {
					display: 'block',
					opacity: 0.5,
					height: $(window).height(),
					width: $(window).width(),
					position: 'fixed',
					left: 0,
					top: 0,
					background: '#333333',
					zIndex: 200 + 1
				}))
				.appendTo('body');
				/* Determine Popup Message position */
				message_box.css('width', HSSPopupMessages.width);
				var vertical = HSSPopupMessages.vertical;	var horizontal = HSSPopupMessages.horizontal;
				switch (HSSPopupMessages.position) {
					case 'center':
						vertical = ( $(window).height() - message_box.height() ) / 2;
						horizontal = ( $(window).width() - message_box.width() ) / 2;
						message_box.css({"top":vertical + 'px', "left":horizontal + 'px'});
						break;
					case 'tl':
						message_box.css({"top":vertical + 'px', "left":horizontal + 'px'});
						break;
					case 'tr':
						message_box.css({"top":vertical + 'px', "right":horizontal + 'px'});
						break;
					case 'bl':
						message_box.css({"bottom":vertical + 'px', "left":horizontal + 'px'});
						break;
					case 'br':
						message_box.css({"bottom":vertical + 'px', "right":horizontal + 'px'});
						break;
				}
			
				/* Here we control closing and opeing effects and controls */
				if (HSSPopupMessages.opendelay != 0) { 
					setTimeout( function() {HSSPopupMessages.open()}, HSSPopupMessages.opendelay * 1000 );
				} else { HSSPopupMessages.open(); }
				if (HSSPopupMessages.autoclose != 0) {
					HSSPopupMessages.countDownClose(HSSPopupMessages.autoclose);
				}
				if (HSSPopupMessages.hover_autoclose == '1') {
					message_box.hover(function() {
						clearTimeout(HSSPopupMessages.countDown);
						$('.message-timer').fadeOut('slow');
						}, function() {
							/* Suggest something to do here! */
						}
					);
				}
				$('a.message-close').click(function() { HSSPopupMessages.close();	return false; });
				/* Esc key handler for closing the message. This doesn't work on Safari or Chrome
					 See the issue here: http://code.google.com/p/chromium/issues/detail?id=14635
				*/
				$(document).keypress(function(e){
					if(e.keyCode==27){  
						HSSPopupMessages.close();
						return false; 
					}
				});
			
				/* Determine Popup Message position for IE6 bug with fixed display */
				
				/*if (HSSPopupMessages.fixed == '1' && !($.browser.msie && $.browser.version == '6.0')) {
					message_box.css({"position":"fixed"});
				}
				else { //IE6 handing
					message_box.css({"position":"absolute"});
					$(window).scroll(function() { message_box.stop().css({top:($(window).scrollTop() + vertical) + 'px'});});
				}*/
			}
		}
	}
})(jQuery);
;
(function ($) {

Drupal.toolbar = Drupal.toolbar || {};

/**
 * Attach toggling behavior and notify the overlay of the toolbar.
 */
Drupal.behaviors.toolbar = {
  attach: function(context) {

    // Set the initial state of the toolbar.
    $('#toolbar', context).once('toolbar', Drupal.toolbar.init);

    // Toggling toolbar drawer.
    $('#toolbar a.toggle', context).once('toolbar-toggle').click(function(e) {
      Drupal.toolbar.toggle();
      // Allow resize event handlers to recalculate sizes/positions.
      $(window).triggerHandler('resize');
      return false;
    });
  }
};

/**
 * Retrieve last saved cookie settings and set up the initial toolbar state.
 */
Drupal.toolbar.init = function() {
  // Retrieve the collapsed status from a stored cookie.
  var collapsed = $.cookie('Drupal.toolbar.collapsed');

  // Expand or collapse the toolbar based on the cookie value.
  if (collapsed == 1) {
    Drupal.toolbar.collapse();
  }
  else {
    Drupal.toolbar.expand();
  }
};

/**
 * Collapse the toolbar.
 */
Drupal.toolbar.collapse = function() {
  var toggle_text = Drupal.t('Show shortcuts');
  $('#toolbar div.toolbar-drawer').addClass('collapsed');
  $('#toolbar a.toggle')
    .removeClass('toggle-active')
    .attr('title',  toggle_text)
    .html(toggle_text);
  $('body').removeClass('toolbar-drawer').css('paddingTop', Drupal.toolbar.height());
  $.cookie(
    'Drupal.toolbar.collapsed',
    1,
    {
      path: Drupal.settings.basePath,
      // The cookie should "never" expire.
      expires: 36500
    }
  );
};

/**
 * Expand the toolbar.
 */
Drupal.toolbar.expand = function() {
  var toggle_text = Drupal.t('Hide shortcuts');
  $('#toolbar div.toolbar-drawer').removeClass('collapsed');
  $('#toolbar a.toggle')
    .addClass('toggle-active')
    .attr('title',  toggle_text)
    .html(toggle_text);
  $('body').addClass('toolbar-drawer').css('paddingTop', Drupal.toolbar.height());
  $.cookie(
    'Drupal.toolbar.collapsed',
    0,
    {
      path: Drupal.settings.basePath,
      // The cookie should "never" expire.
      expires: 36500
    }
  );
};

/**
 * Toggle the toolbar.
 */
Drupal.toolbar.toggle = function() {
  if ($('#toolbar div.toolbar-drawer').hasClass('collapsed')) {
    Drupal.toolbar.expand();
  }
  else {
    Drupal.toolbar.collapse();
  }
};

Drupal.toolbar.height = function() {
  var $toolbar = $('#toolbar');
  var height = $toolbar.outerHeight();
  // In modern browsers (including IE9), when box-shadow is defined, use the
  // normal height.
  var cssBoxShadowValue = $toolbar.css('box-shadow');
  var boxShadow = (typeof cssBoxShadowValue !== 'undefined' && cssBoxShadowValue !== 'none');
  // In IE8 and below, we use the shadow filter to apply box-shadow styles to
  // the toolbar. It adds some extra height that we need to remove.
  if (!boxShadow && /DXImageTransform\.Microsoft\.Shadow/.test($toolbar.css('filter'))) {
    height -= $toolbar[0].filters.item("DXImageTransform.Microsoft.Shadow").strength;
  }
  return height;
};

})(jQuery);
;