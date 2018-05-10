<?php global $base_url; ?>
<div class="col-left-search">
	<div class="tops">Công cụ tìm kiếm</div>
	<div class="contents">
		<div class="tab-act">
			Tin đăng<br>rao bán
		</div>
		<form name="frmSearchFull" action="<?php echo $base_url?>/tim-kiem-nhieu" method="GET" name="frmSearchFull">
		<div class="wrap-search-content">
			<div class="line-search">
				<input type="text" class="txtKeyword" name="txtKeyword" placeholder="Nhập từ khóa tìm kiếm" />
			</div>
			<div class="line-search">
				<select class="select-box" name="txtCat">
		    		<?php 
		    			foreach ($arrOptionsCategoryFull as $k => $v) {
		    				echo '<option value="'.$k.'">'.$v.'</option>';
		    			}
		    		?>
		    	</select>
			</div>
			<div class="line-search">
				<select class="select-box" name="txtProvice" id="frmProvice">
		    		<option value="0">--Tỉnh/Thành phố--</option>
					<?php echo $arrProvice ?>
		    	</select>
			</div>
			<div class="line-search">
				<select class="select-box" name="txtDistrict" id="frmDistrict">
		    		<option> --Chọn Quận/Huyện-- </option>
		    	</select>
			</div>
			<div class="line-search">
				<select class="select-box" name="txtArea">
		    		<option> --Chọn diện tích-- </option>
		    	</select>
			</div>
			<div class="line-search">
				<select class="select-box" name="txtPrice">
		    		<option> --Chọn mức giá-- </option>
		    	</select>
			</div>
			<div class="line-search">
				<!--<a class="lbl-search" href="">Tìm nâng cao</a>-->
				<input type="submit" class="btn-search-ext" />
			</div>
			<div class="txt-note-search">Có <b>2000</b> tin mới mỗi ngày </div>
		</div>
		</form>
	</div>
</div>
<div class="col-center-post theme-project">
	<div class="title-box-item-content"><span>Dự án nổi bật</span></div>
	<ul>
		<?php foreach($list_news_hot as $k => $v){ ?>
		<li>
			<div class="item-box-post-line">
	             <div class="img-post-thumb">
	                <a  target="_blank" href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>">
	                    <?php 
	                        $img='';
	                        if($v->img!=''){
	                            $img = "news/".$v->img;
	                        }else{
	                            $img = "default.jpg";
	                        }
	                        $img = modThumbBase( $img, 200, 150, $alt="$v->title", true, 100, false, "" );
	                        echo $img;
	                    ?>
	                </a>
	            </div>
	            <div class="title-post">
	                <a  target="_blank" href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>"><?php echo $v->title?></a>
	            </div>
	        </div>
		</li>        
		<?php } ?>
	</ul>
</div>
	

