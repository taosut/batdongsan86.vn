<?php
	global $base_url;
?>
<div class="content-detail">
	<?php foreach($oneItem as $v){
		$title = $v->title;
		$meta_title = $v->meta_title;
		$meta_keyword = $v->meta_keywords;
		$meta_description = $v->meta_description;
		$img='';
		if($v->img != ''){
			$img = $base_url.'/uploads/images/news/'.$v->img;
	}

	$clsSeo = new clsSeo();
	$clsSeo->SEO($title, $img, $meta_title, $meta_keyword, $meta_description);
	?>	
	<h1><?php echo $v->title ?></h1>
	<div class="created"><?php echo date('h:i d/m/Y',$v->created)?></div>
	<div class="social-view">
		<div class="like-facebook">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=1406620156256966";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-like" data-href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
		</div>
		<div class="social-share">
			<a target="_blank" class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="share facebook" rel="nofollow">share facebook</a>
			<a target="_blank" class="google" href="https://plus.google.com/share?url=<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="share google" rel="nofollow">share google</a>
			<a target="_blank" class="zing" href="http://link.apps.zing.vn/share?u=<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="share zing" rel="nofollow">share zing</a>
		</div>
	</div>
	<h2 class="intro-view"><?php echo $v->intro ?></h2>
	<div class="detail-article-content"><?php echo $v->content ?></div>
	<?php } ?>

	<div class="same-view"><span>Bài viết khác:</span></div>
	<ul class="list-same-post">
		<?php 
			foreach($arrSameItem as $v){
		?>
		<li><a href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>"><?php echo $v->title?></a> <span>(<?php echo date('h:i d/m/Y',$v->created)?>)</span></li>
		<?php } ?>
	</ul>
</div>