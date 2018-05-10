<?php
	global $base_url;
?>
<?php global $base_url; ?>
<div class="container-common">
    <div class="box-header">
        <div align="center" class="name-title">
            <h4>Thống kê truy cập</h4>
        </div>
    </div>
    <div class="border-box static">
        <?php 
		$block = module_invoke('counter','block_view','1');
		echo render($block['content']);
	?>
    </div>
</div>