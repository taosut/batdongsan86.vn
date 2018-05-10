<?php
	global $base_url;
	$keyword = isset($_GET['txtKeyword']) ? trim($_GET['txtKeyword']) : '';
?>
<div class="box-search">
	<div class="home-top-search">
		<form name="frmSearch" action="<?php echo $base_url?>/tim-kiem" method="GET" name="frmSearch">
			<div class="home-top-search-keyword">
		        <input type="text" id="txtKeyword" value="<?php echo $keyword ?>" placeholder="Nhập từ khóa" name="txtKeyword" class="txtKeyword">
		    </div>
		    <div class="advance-select-box-wrap">
		    	<select name="txtCat" class="advance-select-box">
		    		<?php						
		    			$option_search =  $clsCategory->list_category_root_search();
		    			echo $option_search;
		    		?>
		    	</select>
		    </div>
		    <input type="submit" name="btnsearch" class="btn-search" value="Tìm kiếm"/>
	    </form>
	</div>
</div>