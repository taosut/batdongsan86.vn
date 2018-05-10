<?php
	global $base_url;
	$keyword = isset($_GET['txtKeyword']) ? trim($_GET['txtKeyword']) : '';
?>
<div class="txt-header-search">Kết quả tìm kiếm bài viết với từ khóa "<?php echo $keyword ?>"</div>
<?php if(count($arrItem)>0){
	foreach($arrItem as $k => $v){
?>
	<div class="line-item-post-list other">
		<div class="item-thumb-img">
			<a href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>">
	            <?php 
					$img='';
					if($v->img!=''){
						$img = "news/".$v->img;
					}else{
						$img = "default.jpg";
					}
					$img = modThumbBase( $img, 150, 180, $alt="$v->title", true, 100, false, "" );
					echo $img;
				?>
	        </a>
		</div>
		<h3>
            <a href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>">
          		<?php echo clsString::substring($v->title, $length = 200, $replacer='...')?>
          	</a>
        </h3>
		<div class="created"><?php echo date('h:i d/m/Y',$v->created)?></div>
		<div class="item-intro-txt"><?php echo clsString::substring($v->intro, $length = 300, $replacer='...')?></div>
	</div>
<?php } ?>
<div class="list-page-show front-end">
	<?php echo render($listPage['pager']);?>
</div>
<?php } ?>
