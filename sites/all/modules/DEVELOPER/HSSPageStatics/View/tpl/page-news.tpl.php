<?php
	global $base_url;
?>
<?php if(count($arrItem)>0){
	foreach($arrItem as $k => $v){
		if($k==0){
	?>
	<div class="line-item-post-list">
		<div class="item-thumb-img">
			<a href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>">
	            <?php 
					$img='';
					if($v->img!=''){
						$img = "news/".$v->img;
					}else{
						$img = "default.jpg";
					}
					$img = modThumbBase( $img, 300, 180, $alt="$v->title", true, 100, false, "" );
					echo $img;
				?>
	        </a>
		</div>
		<div class="item-line-intro">
			<h2>
				<a href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>">
	          		<?php echo clsString::substring($v->title, $length = 200, $replacer='...')?>
	          	</a>
			</h2>
			<div class="created"><?php echo date('h:i d/m/Y',$v->created)?></div>
			<div class="item-intro-txt"><?php echo clsString::substring($v->intro, $length = 400, $replacer='...')?></div>
		</div>
	</div>
	<?php }else{?>
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
<?php } ?>
<div class="list-page-show front-end">
	<?php echo render($listPage['pager']);?>
</div>
<?php } ?>
