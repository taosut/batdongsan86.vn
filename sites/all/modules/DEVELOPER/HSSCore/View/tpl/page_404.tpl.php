<?php 
	global $base_url;
?>
<div class="content-page">
	<div style="padding-top:50px;"><img src="<?php echo $base_url.'/'.path_to_theme()?>/View/img/404.png" /></div>
	<?php //echo t('Không tìm thấy trang này!')?>
</div>
<?php
	header('Refresh: 5; url="'.$base_url.'"');
?>