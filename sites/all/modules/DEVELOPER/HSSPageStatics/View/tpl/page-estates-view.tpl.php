<?php
	global $base_url;
?>
<?php foreach($oneItem as $v){
	$cat_name = $v->cat_name;
	$title = $v->title;
	$meta_title = $v->meta_title;
	$meta_keyword = $v->meta_keywords;
	$meta_description = $v->meta_description;
	$img='';
	if($v->img != ''){
		$img = $base_url.'/uploads/images/estates/'.$v->img;
	}

	$clsSeo = new clsSeo();
	$clsSeo->SEO($title, $img, $meta_title, $meta_keyword, $meta_description);
?>
<div class="content-detail">
	<h1><?php echo $v->title ?></h1>
	<div class="social-view">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=1406620156256966";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-like" data-href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
			<div class="social-share">
				<a target="_blank" class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="share facebook" rel="nofollow">share facebook</a>
				<a target="_blank" class="google" href="https://plus.google.com/share?url=<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="share google" rel="nofollow">share google</a>
				<a target="_blank" class="zing" href="http://link.apps.zing.vn/share?u=<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="share zing" rel="nofollow">share zing</a>
			</div>
		</div>
	<div class="content-box-area">
		<b>Khu vực:</b> <?php echo $v->title_dictrict.', '.$v->title_provice ?>
	</div>
	<div class="content-box-area-price">
		<?php 
			$unit = 'Thỏa thuận';
			if($v->unit==356){
				$unit = 'Triệu';
			}elseif($v->unit==357){
				$unit = 'Tỷ';
			}elseif($v->unit==358){
				$unit = 'USD';
			}elseif($v->unit==359){
				$unit = 'Trăm nghìn/m²';
			}elseif($v->unit==360){
				$unit = 'Triệu/m²';
			}elseif($v->unit==361){
				$unit = 'USD/m²';
			}else{
				$unit = 'Thỏa thuận';
			}
		?>
		<b> Giá:</b> <strong><?php if($v->price==0){ echo 'Thỏa thuận'; }else{echo number_format(floatval($v->price),0)." $unit";} ?></strong>
		<b style="padding-left:30px;"> Diện tích:</b> <strong><?php if($v->area==0){echo 'Không xác định';}else{echo $v->area.' m²';} ?></strong>
	</div>
	<div class="detail-article-content"><?php echo $v->content ?></div>
	<div class="img-view-more">
		<?php 
			if($v->img!=''){
				$img = "estates/".$v->img;
				$img = modThumbBase($img, 500, 500, $alt="$v->title", true, 100, false, "" );
				echo $img;
			}
		?>
	</div>
</div>
<div class="box-info-view">
	<div class="box-info-view-left">
		<div class="title-box-view">Thông tin liên hệ</div>
		<div class="item-box-view"><span class="txt-item-box">Tên liên hệ: </span><span class="txt-item-box-info"><?php echo $v->contact ?></span></div>
		<div class="item-box-view"><span class="txt-item-box">Điện thoại: </span><span class="txt-item-box-info"><?php echo $v->contact_phone ?></span></div>
		<div class="item-box-view"><span class="txt-item-box">Email: </span><span class="txt-item-box-info"><?php echo $v->contact_mail ?></span></div>
	</div>
	<div class="box-info-view-right">
		<div class="title-box-view">Thông tin bất động sản</div>
		<div class="item-box-view"><span class="txt-item-box">Địa chỉ: </span><span class="txt-item-box-info"><?php echo $v->title_dictrict.', '.$v->title_provice ?></span></div>
		<div class="item-box-view"><span class="txt-item-box">Mã tin: </span><span class="txt-item-box-info">#<?php echo $v->id ?></span></div>
		<div class="item-box-view"><span class="txt-item-box">Loại tin rao: </span><span class="txt-item-box-info"><?php echo $v->cat_name ?></span></div>
		<div class="item-box-view last"><span class="txt-item-box">Ngày đăng tin: </span><span class="txt-item-box-info"><?php echo date('d-m-Y',$v->created)?></span></div>
	</div>
</div>
<?php } ?>

<div class="txt-header-cat ext"><?php echo $cat_name ?></div>
<?php 
	foreach ($arrSameItem as $v) {
?>
<div class="item-line-estates other">
	<div class="p-title <?php if($v->focus==1){?>star<?php } ?>">
        <a href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>"><?php echo $v->title?></a>
    </div>
    <div class="p-content-item">
    	<div class="p-main-image-thumb">
            <a href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>">
                <?php 
					$img='';
					if($v->img!=''){
						$img = "estates/".$v->img;
					}else{
						$img = "default.jpg";
					}
					$img = modThumbBase( $img, 150, 150, $alt="$v->title", true, 100, false, "" );
					echo $img;
				?>
            </a>
        </div>
        <div class="p-content"><?php echo clsString::substring($v->content, $length = 300, $replacer='...')?></div>
        <div class="p-bottom">
        	<div class="info-item">
                 <?php 
						$unit = 'Thỏa thuận';
						if($v->unit==356){
							$unit = 'Triệu';
						}elseif($v->unit==357){
							$unit = 'Tỷ';
						}elseif($v->unit==358){
							$unit = 'USD';
						}elseif($v->unit==359){
							$unit = 'Trăm nghìn/m²';
						}elseif($v->unit==360){
							$unit = 'Triệu/m²';
						}elseif($v->unit==361){
							$unit = 'USD/m²';
						}else{
							$unit = 'Thỏa thuận';
						}
					?>
                 Giá: <span class="product-price"><?php if($v->price==0){ echo 'Thỏa thuận'; }else{echo number_format(floatval($v->price),0)." $unit";} ?></span>&nbsp;
                 Diện tích: <span class="product-area"><?php if($v->area==0){echo 'Không xác định';}else{echo $v->area.' m²';} ?></span>&nbsp;
                 Quận/Huyện: <span class="product-city-dist"><?php echo $v->title_dictrict .', '. $v->title_provice ?></span>
            </div>
        	<div class="date-create"><?php echo date('d/m/Y',$v->created)?></div>
        </div>
    </div>
</div>
<?php } ?>