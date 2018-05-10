<?php global $base_url; ?>
<div class="mid-ad-item">
	<?php 
			foreach($ads_middle as $v){
			$filename = $v->img;
			if(clsUtility::chkFileExtension($filename)=='yes'){ ?>
			<a href="javascript:void(0)" title="<?php echo $v->title_show?>" rel="nofollow">	
				<object width="1000px" height="100px" border="0" 
				classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" 
				codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" 
				bannerid="<?php echo $v->id?>" class="view-count" id="obj2406">
				<param name="movie" value="<?php echo $base_url."/uploads/images/ads/".$filename?>">
				<param name="flashvars" value="link=<?php echo $base_url?>">
				<param name="AllowScriptAccess" value="always"><param name="quality" value="High">
				<param name="wmode" value="transparent">
				<embed width="1000px" height="100px" 
				flashvars="link=<?php echo $base_url?>" 
				src="<?php echo $base_url."/uploads/images/ads/".$filename?>" 
				pluginspage="http://www.macromedia.com/go/getflashplayer" 
				type="application/x-shockwave-flash" play="true" loop="true" 
				wmode="transparent" allowscriptaccess="always" name="obj2406">
			</object>
			</a>
			<?php }else{ ?>
			<a href="<?php echo $v->link?>" title="<?php echo $v->title_show?>" rel="nofollow" target="_blank"> 
				<img src="<?php echo $base_url."/uploads/images/ads/".$filename?>" alt="<?php echo $v->title_show ?>"/>
			</a>
			<?php 
				} 
			}
			?>
</div>


