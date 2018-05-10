<?php global $base_url; ?>
<div class="list-post-item-content">
	<div class="title-box-item-content"><span>Tin rao dành cho bạn</span></div>
	<div class="box-item-content-post">
		
		<?php
		foreach($list_estate['item'] as $v){?>
		<div class="line-item-post">
			<div class="main-image-thumb">
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
			<div class="p-content">
				<h3><a href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>"><?php echo $v->title?></a></h3>
			</div>
			<div class="p-bottom-intro">
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
				<div><div class="left">Giá</div>:&nbsp;<?php if($v->price==0){ echo 'Thỏa thuận'; }else{echo number_format(floatval($v->price),0)." $unit";} ?></div>
                <div><div class="left">Diện tích</div>:&nbsp;<?php if($v->area==0){echo 'Không xác định';}else{echo $v->area.' m²';} ?></div>
                <div>
                    <div class="left">Quận/huyện</div>:&nbsp;
                	<div class="bottom-right-address"><?php echo $v->title_dictrict .', '. $v->title_provice ?></div>
                	<div class="p-bottom-right"><?php echo date('d/m/Y',$v->created)?></div>
                </div>
			</div>
		</div>
		<?php } ?>

		<div class="list-page-show front-end">
			<?php echo render($list_estate['pager']);?>
		</div>
	</div>
</div>