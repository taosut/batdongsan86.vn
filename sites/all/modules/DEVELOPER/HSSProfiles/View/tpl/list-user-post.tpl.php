<?php 
	global $base_url;
?>
<div class="main-post-estate ">
	<div class="wrap-main-post-estate">
		<div class="box-user-change">
			<div class="box-user-change-right">
				<div class="box-table-list">
					<div class="tb-list-estate">
						<div class="th-list">
							<div class="td-stt">Stt</div>
							<div class="td-code">Mã tin</div>
							<div class="td-title">Tiêu đề</div>
							<div class="td-view">Lượt xem</div>
							<div class="td-created">Ngày đăng</div>
						</div>
						<?php 
						$i=0;
						foreach($arrItem as $v){
						$i++;
						?>
						<div class="tr-list">
							<div class="td-stt"><?php echo $i ?></div>
							<div class="td-code">#<?php echo $v->id?></div>
							<div class="td-title"><a target="_blank" title="<?php echo $v->title?>" href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>"><?php echo $v->title?></a></div>
							<div class="td-view"><?php echo $v->view?></div>
							<div class="td-created"><?php echo date('h:i d-m-Y',$v->created)?></div>
							<span class="action-item">
								<a title="Sửa" href="<?php echo $base_url.'/sua-tin-dang/'.$v->id?>" class="editItemEstates">Sửa</a>
								<a title="Xóa" href="javascript:void(0)" class="delItemEstates" dataid="<?php echo $v->id?>">Xóa</a>
							</span>
						</div>
						<?php } ?>
						<?php if(count($arrItem)>0){ ?>
						<div class="list-page-show front-end">
							<?php echo render($listPage['pager']);?>
						</div>
						<?php } ?>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>