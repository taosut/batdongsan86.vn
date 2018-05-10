<?php
	global $base_url;
	$keyword = isset($_GET['txtKeyword']) ? trim($_GET['txtKeyword']) : '';
?>
<div class="txt-header-cat">Kết quả tìm kiếm tin bất động sản với từ khóa "<?php echo $keyword ?>"</div>

<?php 
	foreach ($arrItem as $v) {
?>
<div class="item-line-estates">
	<h3 class="p-title <?php if($v->focus==1){?>star<?php } ?>">
        <a href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>"><?php echo $v->title?></a>
    </h3>
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
<div class="list-page-show front-end">
	<?php echo render($listPage['pager']);?>
</div>