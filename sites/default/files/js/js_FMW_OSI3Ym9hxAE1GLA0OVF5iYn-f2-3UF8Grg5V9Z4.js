jQuery(document).ready(function($){
	GET_DICTRICTS.init();
});

GET_DICTRICTS = {
	init:function(){
		jQuery('select[name="txtProvice"]').change(function(){
			jQuery('select[name="txtProvice"] option:selected').each(function(){
				var provice_id = jQuery('select[name="txtProvice"]').val();
				//ajax load dictrict
				var domain = BASEPARAMS.base_url;
				var url = domain + '/admincp/dictricts/getdictricts';
				if(provice_id > 0){
					jQuery('#ajaxLoadingPost').css('display', 'block');
					jQuery.ajax({
						type: "POST",
						url: url,
						data: "provice_id=" + encodeURI(provice_id),
						success: function(data){
							jQuery('select[name="txtDictrict"]').html(data);
							jQuery('#ajaxLoadingPost').css('display', 'none');
						}
					});	
				}			
			});
	   });
	   if(jQuery('select[name="txtProvice"]').val()>0){
			var provice_id = jQuery('select[name="txtProvice"]').val();
			var estates_id = jQuery('input[name="txtId"]').val();
			//ajax load dictrict
			var domain = BASEPARAMS.base_url;
			var url = domain + '/admincp/dictricts/getdictricts';
			if(provice_id > 0){
				jQuery('#ajaxLoadingPost').css('display', 'block');
				jQuery.ajax({
					type: "POST",
					url: url,
					data: "provice_id=" + encodeURI(provice_id) + "&estates_id=" + encodeURI(estates_id),
					success: function(data){
						jQuery('select[name="txtDictrict"]').html(data);
						jQuery('#ajaxLoadingPost').css('display', 'none');
					}
				});	
			}
		}
	}
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
	CHECKALL_ITEM.init();
	HISTORY_BACK.init();
	HIDDEN_MENU_ADMIN.init();
	HIDDEN_MENU_ADMIN.init_box();
});

CHECKALL_ITEM = {
	init:function(){
		jQuery("input#checkAll").click(function(){
			var checkedStatus = this.checked;
			jQuery("input.checkItem").each(function(){
				this.checked = checkedStatus;
			});
		});
	}
}
/*
EDIT_ITEM={
	init:function(path_menu){
		jQuery('a#editOneItem').click(function(){
			var total = jQuery( "input:checked" ).length;
			if(total==0 || total>1){
				alert('Please select one item to edit!');
				return false;
			}else{
				jQuery('form#formListItem').attr("action", BASEPARAMS.base_url+"/"+path_menu+"/edit");
				jQuery('form#formListItem').submit();
				return true;
			}
		});
	}
}
*/
DELETE_ITEM={
	init:function(path_menu){
		jQuery('a#deleteMoreItem, a#deleteOneItem').click(function(){
			var total = jQuery( "input:checked" ).length;
			if(total==0){
				alert('Please select at least 1 item to delete!');
				return false;
			}else{
				if (confirm('Do you want to delete[OK]:Yes[Cancel]:No?)')){
					jQuery('form#formListItem').attr("action", BASEPARAMS.base_url+"/"+path_menu+"/delete");
					jQuery('form#formListItem').submit();
					return true;
				}
				return false;
			}
		});
	}
}

HISTORY_BACK = {
	init:function(){
		jQuery("button[type=reset]").click(function(){
	   		window.history.back();
	   });
	}
}

FORMAT_NUMBER={
	init:function(nStr){
		nStr += '';
	    var x = nStr.split('.');
	    var x1 = x[0];
	    var x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    return x1 + x2;
	}
}

HIDDEN_MENU_ADMIN = {
	init:function(){
		jQuery(".logo").click(function(){
			jQuery('.pageWrapper').toggleClass('act');
		});
	},
	init_box:function(){
		var rightRegion = jQuery('.rightRegion').height();
		var navigation_ul = jQuery(".leftRegion .navigation ul").height(jQuery(".leftRegion").height());

		if(rightRegion < navigation_ul.height()){
			jQuery('.rightRegion').height(navigation_ul.height());
		}else{
			jQuery('.leftRegion .navigation ul').height(jQuery(".rightRegion").height());
		}
	}
}
;
(function($) {
    $.fn.html5Uploader = function(options) {
        var crlf = '\r\n';
        var boundary = "upload ajax";
        var dashes = "--";
        var settings = {
            "name" : "uploadedFile",
            "postUrl" : "Upload.php",
            "onClientAbort" : null,
            "onClientError" : null,
            "onClientLoad" : null,
            "onClientLoadEnd" : null,
            "onClientLoadStart" : null,
            "onClientProgress" : null,
            "onServerAbort" : null,
            "onServerError" : null,
            "onServerLoad" : null,
            "onServerLoadStart" : null,
            "onServerProgress" : null,
            "onServerReadyStateChange" : null,
            "onSuccess" : null
        };
        if (options) {
            $.extend(settings, options);
        }
        return this.each(function(options) {
            var $this = $(this);
            if ($this.is("[type='file']")) {
                $this.bind("change", function() {
                    var files = this.files;
                    for (var i = 0; i < files.length; i++) {
                        fileHandler(files[i]);
                    }
                });
            } else {
                $this.bind("dragenter dragover", function() {
                    $(this).addClass("hover");
                    return false;
                }).bind("dragleave", function() {
                        $(this).removeClass("hover");
                        return false;
                    }).bind("drop", function(e) {
                        $(this).removeClass("hover");
                        var files = e.originalEvent.dataTransfer.files;
                        for (var i = 0; i < files.length; i++) {
                            fileHandler(files[i]);
                        }
                        return false;
                    });
            }
        });
        function fileHandler(file) {
            var fileReader = new FileReader();
            fileReader.onabort = function(e) {
                if (settings.onClientAbort) {
                    settings.onClientAbort(e, file);
                }
            };
            fileReader.onerror = function(e) {
                if (settings.onClientError) {
                    settings.onClientError(e, file);
                }
            };
            fileReader.onload = function(e) {
                if (settings.onClientLoad) {
                    settings.onClientLoad(e, file);
                }
            };
            fileReader.onloadend = function(e) {
                if (settings.onClientLoadEnd) {
                    settings.onClientLoadEnd(e, file);
                }
            };
            fileReader.onloadstart = function(e) {
                if (settings.onClientLoadStart) {
                    settings.onClientLoadStart(e, file);
                }
            };
            fileReader.onprogress = function(e) {
                if (settings.onClientProgress) {
                    settings.onClientProgress(e, file);
                }
            };
            fileReader.readAsDataURL(file);
            var xmlHttpRequest = new XMLHttpRequest();
            xmlHttpRequest.upload.onabort = function(e) {
                if (settings.onServerAbort) {
                    settings.onServerAbort(e, file);
                }
            };
            xmlHttpRequest.upload.onerror = function(e) {
                if (settings.onServerError) {
                    settings.onServerError(e, file);
                }
            };
            xmlHttpRequest.upload.onload = function(e) {
                if (settings.onServerLoad) {
                    settings.onServerLoad(e, file);
                }
            };
            xmlHttpRequest.upload.onloadstart = function(e) {
                if (settings.onServerLoadStart) {
                    settings.onServerLoadStart(e, file);
                }
            };
            xmlHttpRequest.upload.onprogress = function(e) {
                if (settings.onServerProgress) {
                    settings.onServerProgress(e, file);
                }
            };
            xmlHttpRequest.onreadystatechange = function(e) {
                if (settings.onServerReadyStateChange) {
                    settings.onServerReadyStateChange(e, file, xmlHttpRequest.readyState);
                }
                if (settings.onSuccess && xmlHttpRequest.readyState == 4 && xmlHttpRequest.status == 200) {
                    settings.onSuccess(e, file, JSON.parse(xmlHttpRequest.responseText));
                }
            };
            xmlHttpRequest.open("POST", settings.postUrl, true);
            if (file.getAsBinary) {
                var data = dashes + boundary + crlf + "Content-Disposition: form-data;" + "name=\"" + settings.name + "\";" + "filename=\"" + unescape(encodeURIComponent(file.name)) + "\"" + crlf + "Content-Type: application/octet-stream" + crlf + crlf + file.getAsBinary() + crlf + dashes + boundary + dashes;
                xmlHttpRequest.setRequestHeader("Content-Type", "multipart/form-data;boundary=" + boundary);
                xmlHttpRequest.sendAsBinary(data);
            } else if (window.FormData) {
                var formData = new FormData();
                formData.append(settings.name, file);
                xmlHttpRequest.send(formData);
            }
        }

    };
})(jQuery); ;
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/

jQuery(document).ready(function(){
	try{
		var url_upload = BASEPARAMS.base_url+'/admincp/estates/uploadFile';
		UPLOAD_FILE.uploadhtml5(url_upload);
		UPLOAD_FILE.edit();
	}catch (e){
    }
});

/*upload with html5*/
UPLOAD_FILE = {
    uploadhtml5:function(url){
        jQuery("#txtImagesPost").html5Uploader({
            name: "txtImagesPost",
            onServerLoadStart:function(e,file){
                var aType = file.type.split('/');
				if(aType[0] =='image'){
                    var id = UPLOAD_FILE.slugify(file.name);
					jQuery('#load_file_ajax').append('<div class = "rowprocess" id = "'+id+'" ></div>');
					jQuery('#'+id+' p').css('width','10%');
                }
            },
			onServerProgress:function(e,file){
				if(e.lengthComputable){
					var id = UPLOAD_FILE.slugify(file.name);
					var percentComplete=(e.loaded/e.total)*100;
					jQuery('#'+id+' p').css('width',percentComplete+'%');
				}
			},

			onServerLoad:function(e,file){
				var id = UPLOAD_FILE.slugify(file.name);
				var link_duplicate = jQuery('#'+id+' p img').attr('alt');
				jQuery('input[value="'+link_duplicate+'"]').remove();
				jQuery('#'+id+' p').remove();
				//remove duplicatefile
				UPLOAD_FILE.ajax_delete(link_duplicate);
			},

			onSuccess:function(e, file, data){
				var id = UPLOAD_FILE.slugify(file.name);
				jQuery('#'+id).append('<input type="hidden" name="link_file[]" value="'+data.src+'" >');
				var data_link = jQuery('#'+id+' input').val();
				var html = '<div class = "rowprocess" id = "'+id+'" >'
					+'<p style="width:75px!important">'
						+'<img src="'+BASEPARAMS.base_url+'/uploads/images/estates/'+data_link+'" alt="'+data_link+'" width="50" height="50"/>'
						+'<a id="del'+id+'"  href="javascript:void(0)" class="textr delete ">Xóa ảnh</a>'
					+'</p>'
					+'</div>';
				jQuery('#load_file_ajax').append(html);
				UPLOAD_FILE.dellink(id,data.src);
			},
			postUrl: url,
       });
    },

    slugify:function (text){
        text=text.replace(/[^-a-zA-Z0-9,&\s]+/ig,'');
        text=text.replace(/-/gi,"_");
        text=text.replace(/\s/gi,"-");
        return text;
    },
	//delete click
	dellink:function(id,link){
	    jQuery('#del'+id).click(function(){
			UPLOAD_FILE.ajax_delete(link);
			jQuery('div#'+id).remove();
            return false;
        });
    },
	//delete focus
	ajax_delete:function(link){
		if(typeof link != 'undefined'){
			jQuery.ajax({
				type: "POST",
				url: BASEPARAMS.base_url+'/admincp/estates/deleteFile',
				data: "link=" + encodeURI(link),
				success: function(data){
				}
			});
		}
		return false;
	},
	//remove file in db
	edit:function(){
		 jQuery('a.del_file').click(function(){
			var id_file = jQuery(this).attr('rel');
			var link_file = jQuery(this).attr('title');
			jQuery('div#id_file'+id_file).remove();
			UPLOAD_FILE.ajax_delete(link_file);
			//delete file in db
			jQuery.ajax({
					type: "POST",
					url: BASEPARAMS.base_url+'/admincp/estates/deleteDBFile',
					data: "id_file=" + encodeURI(id_file) + "&link=" + encodeURI(link_file),
					success: function(data){}
				});
            return false;
        });
	},
};;
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
