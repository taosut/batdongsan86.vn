<?php
	global $base_url, $user;
	$param = arg();
	$cat_alias = $param[0];
?>
<div class="header-top">
	<div class="logo">
		<a href="<?php echo $base_url?>" title="Nhà đất"><span></span></a>
	</div>
	<div class="header-right">
		<div class="top-banner">
			<?php 
			foreach($ads_header as $v){
			$filename = $v->img;
			if(clsUtility::chkFileExtension($filename)=='yes'){ ?>
			<a href="javascript:void(0)" title="<?php echo $v->title_show?>" rel="nofollow">	
				<object width="746px" height="96px" border="0" 
				classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" 
				codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" 
				bannerid="<?php echo $v->id?>" class="view-count" id="obj2406">
				<param name="movie" value="<?php echo $base_url."/uploads/images/ads/".$filename?>">
				<param name="flashvars" value="link=<?php echo $base_url?>">
				<param name="AllowScriptAccess" value="always"><param name="quality" value="High">
				<param name="wmode" value="transparent">
				<embed width="746px" height="96px" 
				flashvars="link=<?php echo $base_url?>" 
				src="<?php echo $base_url."/uploads/images/ads/".$filename?>" 
				pluginspage="http://www.macromedia.com/go/getflashplayer" 
				type="application/x-shockwave-flash" play="true" loop="true" 
				wmode="transparent" allowscriptaccess="always" name="obj2406">
			</object>
			</a>
			<?php }else{ ?>
			<a href="<?php echo $v->link?>" title="<?php echo $v->title_show?>" rel="nofollow" target="_blank"> 
				<img src="<?php echo $base_url."/uploads/images/ads/".$filename?>" alt="<?php echo $v->title_show ?>" width="747px" height="96px"/>
			</a>
			<?php 
				} 
			}
		?>
		</div>
		<div class="bottm-hotline">
			<span class='hotline'><?php echo clsUtility::keyword('SITE_HOTLINE')?></span>
			<a href="<?php echo $base_url?>/dang-tin" class='post'>Đăng tin rao</a>
			<!-- <a href="<?php echo $base_url?>/hoi-dap" class='question'>Hỏi đáp</a> -->
			<?php 
				if($user->uid==0){
			?>
			<a href="<?php echo $base_url?>/dang-ky" class="register">Đăng ký</a>
			<a href="<?php echo $base_url?>/user" class="login">Đăng nhập</a>
			<?php 
				}else{
					echo '<div class="box-info-user-login-panel">';
					if($user->fullname==''){
						echo '<a href="javascript:void(0)" class="register"> Chào: '.$user->name.'</a>';
					}else{
						echo '<a href="javascript:void(0)" class="register"> Chào: '.$user->fullname.'</a>';
					}
			?>
					<ul id="control-box" style="display:none;">
						<li><a href="<?php echo $base_url?>/quan-ly-tin-dang" rel="nofollow">Quản lý tin đăng</a></li>
						<li><a href="<?php echo $base_url?>/thay-doi-thong-tin-ca-nhan" rel="nofollow">Thay đổi thông tin cá nhân</a></li>
						<li><a href="<?php echo $base_url?>/thay-doi-mat-khau" rel="nofollow">Thay đổi mật khẩu</a></li>
					</ul>
					</div>
					<a href="<?php echo $base_url ?>/user/logout" class="logout"> Thoát</a>
			<?php		
				}	
			?>
		</div>
	</div>
</div>
<div class="bg-menu">
	<div class="i-index">
		<a href="<?php echo $base_url?>" title="Trang chủ"><span class="icon-home"></span></a>
	</div>
	<ul class="dropdown-navigative-menu">
		<li class="lv0"><a class="haslink" title="Trang chủ&nbsp;" href="<?php echo $base_url ?>">Trang chủ&nbsp;</a>
		<?php
		$total = count($list_menu);
		$i=0;
		foreach($list_menu as $v){
			$i++;
			$lv1_menu = get_sub_menu($v->id);
		?>
		<li class="lv0"><a class="haslink" title="<?php echo $v->title ?>" href="<?php echo $base_url.'/'.$v->title_alias ?>"><?php echo $v->title ?></a>
			<?php if(count($lv1_menu)>0){?>
			<ul>
				<?php foreach ($lv1_menu as $lv1) {
					$lv2_menu = get_sub_menu($lv1->id);
				?>
				<li class="lv1"><a class="haslink" title="<?php echo $lv1->title ?>" href="<?php echo $base_url.'/'.$lv1->title_alias ?>"><?php echo $lv1->title ?></a>
					<?php if(count($lv2_menu)>0){?>
						<ul <?php if($total==$i){?>style="left: -212px " <?php } ?>>
							<?php foreach ($lv2_menu as $lv2) {?>
							<li class="lv2"><a class="haslink" title="<?php echo $lv2->title ?>" href="<?php echo $base_url.'/'.$lv2->title_alias ?>"><?php echo $lv2->title ?></a>
							<?php } ?>
						</ul>
					<?php } ?>
				</li>
				<?php } ?>
			</ul>
			<?php } ?>
		</li>
		<?php } ?>
	</ul>
</div>