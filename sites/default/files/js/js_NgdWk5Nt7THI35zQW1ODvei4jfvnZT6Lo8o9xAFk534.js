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
(function ($) {

/**
 * Attaches sticky table headers.
 */
Drupal.behaviors.tableHeader = {
  attach: function (context, settings) {
    if (!$.support.positionFixed) {
      return;
    }

    $('table.sticky-enabled', context).once('tableheader', function () {
      $(this).data("drupal-tableheader", new Drupal.tableHeader(this));
    });
  }
};

/**
 * Constructor for the tableHeader object. Provides sticky table headers.
 *
 * @param table
 *   DOM object for the table to add a sticky header to.
 */
Drupal.tableHeader = function (table) {
  var self = this;

  this.originalTable = $(table);
  this.originalHeader = $(table).children('thead');
  this.originalHeaderCells = this.originalHeader.find('> tr > th');
  this.displayWeight = null;

  // React to columns change to avoid making checks in the scroll callback.
  this.originalTable.bind('columnschange', function (e, display) {
    // This will force header size to be calculated on scroll.
    self.widthCalculated = (self.displayWeight !== null && self.displayWeight === display);
    self.displayWeight = display;
  });

  // Clone the table header so it inherits original jQuery properties. Hide
  // the table to avoid a flash of the header clone upon page load.
  this.stickyTable = $('<table class="sticky-header"/>')
    .insertBefore(this.originalTable)
    .css({ position: 'fixed', top: '0px' });
  this.stickyHeader = this.originalHeader.clone(true)
    .hide()
    .appendTo(this.stickyTable);
  this.stickyHeaderCells = this.stickyHeader.find('> tr > th');

  this.originalTable.addClass('sticky-table');
  $(window)
    .bind('scroll.drupal-tableheader', $.proxy(this, 'eventhandlerRecalculateStickyHeader'))
    .bind('resize.drupal-tableheader', { calculateWidth: true }, $.proxy(this, 'eventhandlerRecalculateStickyHeader'))
    // Make sure the anchor being scrolled into view is not hidden beneath the
    // sticky table header. Adjust the scrollTop if it does.
    .bind('drupalDisplaceAnchor.drupal-tableheader', function () {
      window.scrollBy(0, -self.stickyTable.outerHeight());
    })
    // Make sure the element being focused is not hidden beneath the sticky
    // table header. Adjust the scrollTop if it does.
    .bind('drupalDisplaceFocus.drupal-tableheader', function (event) {
      if (self.stickyVisible && event.clientY < (self.stickyOffsetTop + self.stickyTable.outerHeight()) && event.$target.closest('sticky-header').length === 0) {
        window.scrollBy(0, -self.stickyTable.outerHeight());
      }
    })
    .triggerHandler('resize.drupal-tableheader');

  // We hid the header to avoid it showing up erroneously on page load;
  // we need to unhide it now so that it will show up when expected.
  this.stickyHeader.show();
};

/**
 * Event handler: recalculates position of the sticky table header.
 *
 * @param event
 *   Event being triggered.
 */
Drupal.tableHeader.prototype.eventhandlerRecalculateStickyHeader = function (event) {
  var self = this;
  var calculateWidth = event.data && event.data.calculateWidth;

  // Reset top position of sticky table headers to the current top offset.
  this.stickyOffsetTop = Drupal.settings.tableHeaderOffset ? eval(Drupal.settings.tableHeaderOffset + '()') : 0;
  this.stickyTable.css('top', this.stickyOffsetTop + 'px');

  // Save positioning data.
  var viewHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
  if (calculateWidth || this.viewHeight !== viewHeight) {
    this.viewHeight = viewHeight;
    this.vPosition = this.originalTable.offset().top - 4 - this.stickyOffsetTop;
    this.hPosition = this.originalTable.offset().left;
    this.vLength = this.originalTable[0].clientHeight - 100;
    calculateWidth = true;
  }

  // Track horizontal positioning relative to the viewport and set visibility.
  var hScroll = document.documentElement.scrollLeft || document.body.scrollLeft;
  var vOffset = (document.documentElement.scrollTop || document.body.scrollTop) - this.vPosition;
  this.stickyVisible = vOffset > 0 && vOffset < this.vLength;
  this.stickyTable.css({ left: (-hScroll + this.hPosition) + 'px', visibility: this.stickyVisible ? 'visible' : 'hidden' });

  // Only perform expensive calculations if the sticky header is actually
  // visible or when forced.
  if (this.stickyVisible && (calculateWidth || !this.widthCalculated)) {
    this.widthCalculated = true;
    var $that = null;
    var $stickyCell = null;
    var display = null;
    var cellWidth = null;
    // Resize header and its cell widths.
    // Only apply width to visible table cells. This prevents the header from
    // displaying incorrectly when the sticky header is no longer visible.
    for (var i = 0, il = this.originalHeaderCells.length; i < il; i += 1) {
      $that = $(this.originalHeaderCells[i]);
      $stickyCell = this.stickyHeaderCells.eq($that.index());
      display = $that.css('display');
      if (display !== 'none') {
        cellWidth = $that.css('width');
        // Exception for IE7.
        if (cellWidth === 'auto') {
          cellWidth = $that[0].clientWidth + 'px';
        }
        $stickyCell.css({'width': cellWidth, 'display': display});
      }
      else {
        $stickyCell.css('display', 'none');
      }
    }
    this.stickyTable.css('width', this.originalTable.outerWidth());
  }
};

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
