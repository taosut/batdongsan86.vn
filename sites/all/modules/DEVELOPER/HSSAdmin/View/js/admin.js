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
}