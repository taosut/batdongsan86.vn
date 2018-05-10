<?php
	global $base_url;
	productLightbox();
?>
<script>
	var url_images= "<?php echo $base_url?>/<?php echo path_to_theme()?>/View/img"
</script>

<div class="topMenuBar style3">
	<?php echo clsUtility:: keyword('SITE_HEADER')?>
</div>
<div class="w850">
	<div class="banner">
		<?php foreach($arrAds as $v){?>
		<a href="<?php echo $v->link?>" title="<?php echo $v->title?>" target="_blank">
			<img src="<?php echo $base_url ?>/uploads/images/ads/<?php echo $v->img ?>" alt="<?php echo $v->title ?>" />
		</a>
		<?php } ?>
	</div>

	<div class="mainContainer">
		<div class="content-box">
			<div class="txt-intro-site">
				<?php echo clsUtility:: keyword('SITE_CONTENT')?>
			</div>
			<?php 
				foreach ($arrProduct as $k => $v) {
					$arrImg = get_all_img($v->id);
					$arrImgGift = get_all_gift($v->id)
			?>
			<script>
				jQuery(function() {
					jQuery('#gallery_<?php echo $k ?> a').lightBox();
					jQuery('#gallery_gift_<?php echo $k ?> a').lightBox();
				});
			</script>
			<div class="item-post <?php if($k%2==0){?>even<?php }else{ ?>odd<?php } ?>">
				<h2 class="title"><strong><?php echo $v->title?></strong></h2>
				<div style="text-align:justify" class="txt-intro-site-item">
					<?php echo $v->content?>
				</div>
				<div class="click-show-intro">
					<span>Xem thêm</span>
				</div>
				<div class="content-post">
					<div class="left-content" id="gallery_<?php echo $k ?>">
						<div class="view-img">
						 	<a href="<?php echo $base_url ?>/uploads/images/product/<?php echo $v->img ?>" title="<?php echo $v->title?>">
						    	<?php
							$img='';
							if($v->img!=''){
								$img = "product/".$v->img;
							}else{
								$img = "default.jpg";
							}
							$img = renderThumbCropCenter($img, 500, 500, $alt="$v->title", true, 100, false, "");
							echo $img;
						?>
							</a>
						</div>
						<?php if(count($arrImg)>0){ ?>
						<div class="arr-img">
							<?php foreach($arrImg as $img){ ?>
							<div class="item-img">
								<a href="<?php echo $base_url?>/uploads/images/product/<?php echo $img->path ?>" title="<?php echo $v->title?>">
									<?php
										if($img->path!=''){
											$img = "product/".$img->path;
										}else{
											$img = "default.jpg";
										}
										$img = renderThumbCropCenter( $img, 150, 90, $alt="", true, 100, false, "" );
										echo $img;
									?>
								</a>
							</div>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
					<div class="right-content" id="gallery_gift_<?php echo $k ?>">
						<div class="txtgift">Quà tặng kèm: Khi mua đồng hồ này bạn được tặng một trong số các mẫu sau</div>
						<?php if(count($arrImgGift)>0){ ?>
						<div class="img-gift">
							<ul>
								<?php foreach($arrImgGift as $img){ ?>
								<li>
									<a href="<?php echo $base_url?>/uploads/images/product/<?php echo $img->path ?>" title="Quà tặng kèm">
									<?php
										if($img->path!=''){
											$img = "product/".$img->path;
										}else{
											$img = "default.jpg";
										}
										$img = renderThumbCropCenter( $img, 200, 100, $alt="", true, 100, false, "" );
										echo $img;
									?>
									</a>	
								</li>
								<?php } ?>
							</ul>
						</div>
						<?php } ?>
						<div class="btnLine">
							<div class="btnbuy" pid="<?php echo $v->id?>">Đăng ký mua đồng hồ này</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<!-- comment facebook-->
		<div class="box-comment-facebook">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1406620156256966&version=v2.0";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-comments" data-href="<?php echo $base_url?>" data-width="835" data-numposts="50" data-colorscheme="light"></div>
		</div>
		<div class="footer"><?php echo clsUtility:: keyword('SITE_FOOTER')?></div>	
	</div>
</div>
<center>
	<div class="w850 signature"><?php echo clsUtility:: keyword('SITE_BOTTOM_FOOTER')?></div>
</center>

<!-- order -->
<div id="dialog_order_view" style="display:none">
	<div class="content-form-order-view">
		<div class="validation-errors">Thông tin đặt hàng không hợp lệ. Bạn vui lòng kiểm tra lại các ô thông tin và ĐẶT HÀNG lại!</div>
		<form method="POST" action="">
			<div class="control-item">
				<input type="text" class="input-item-order" name="txtName" id="txtName" 
				placeholder="Họ Tên Để Nhận Hàng* (bắt buộc)">
			</div>
			<div class="control-item">
				<input type="text" class="input-item-order" name="txtPhone" id="txtPhone" 
				placeholder="Điện Thoại Nhận Hàng* (bắt buộc)">
			</div>
			<div class="control-item">
				<input type="text" class="input-item-order" name="txtAddress" id="txtAddress" 
				placeholder="Đia chỉ* (bắt buộc)">
			</div>
			<div class="line-view-price-item-order">
				<textarea class="text-form" rows="10" cols="40" name="txtNote" id="txtNote" placeholder="Ghi chú" ></textarea>
			</div>
			<div class="line-view-price-item-order">
				<input type="submit" class="submitorder" value="ĐẶT HÀNG NGAY"><span class="ajax-loader"></span>
			</div>
			<div class="line-view-price-item-order-thank" style="display:none">
				Đồng hồ rẻ đẹp sẽ check đơn hàng sớm và liên lạc lại ngay với bạn. Chúc bạn có một ngày vui vẻ!
			</div>
			<input type="hidden" name="pid" id="pid" value="0"/>
		</form>
	</div>
</div>
<!--end order-->