<?php global $base_url; ?>
<div class="container-common">
	<div class="box-header">
        <div align="center" class="name-title">
            <h4>Lời khuyên</h4>
        </div>
    </div>
    <div class="border-box">
    	<div class="list">
    		<ul>
    			<?php foreach($list_advice_hot as $v){?>
                <li>
    				<a  class="link" href="<?php echo $base_url.'/'.$v->cat_alias.'/'.$v->title_alias ?>" title="<?php echo $v->title?>">
                		<?php echo $v->title?>
                	</a>
                </li>
                <?php } ?>
    		</ul>
    	</div>
    </div>
</div>