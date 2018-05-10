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
