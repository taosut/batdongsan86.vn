<?php global $base_url; ?>
<div class="container-common">
    <div class="box-header">
        <div align="center" class="name-title">
            <h4>Dự án nổi bật</h4>
        </div>
    </div>
    <div class="border-box">
        <?php foreach($list_project_hot as $v){?>
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
        <?php } ?>
    </div>
</div>