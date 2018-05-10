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
}