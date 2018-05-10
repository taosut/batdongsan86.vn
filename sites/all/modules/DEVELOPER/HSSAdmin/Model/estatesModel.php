<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
class _Estates extends Estates{

	function listItemPost(){
		global $base_url;

		
		$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
		$status = isset($_GET['status']) ? $_GET['status'] : '';

		$header = array(
				array('data' => '<input type="checkbox" id="checkAll"/>'),
				array('field' => 'i.title','data' => t('Tiêu đề')),
				array('field' => 'i.cat_name','data' => t('Danh mục')),
				array('field' => 'i.provice_name','data' => t('Tỉnh/thành')),
				array('field' => 'i.dictrict_name','data' => t('Quận/huyện')),
				array('field' => 'i.focus','data' => t('Nổi bật')),
				array('field' => 'i.created','data' => t('Ngày tạo')),
				array('field' => 'i.status','data' => t('Trạng thái')),
				array('data' => t('Action'))
		);

		$sql = db_select($this->table, 'i')->extend('PagerDefault')->extend('TableSort');

		$sql->addField('i', 'cat_name', 'cat_name');
		$sql->addField('i', 'provice_name', 'provice_name');
		$sql->addField('i', 'dictrict_name', 'dictrict_name');

		$sql->addField('i', 'id', 'id');
		$sql->addField('i', 'title', 'title');
		$sql->addField('i', 'focus', 'focus');
		$sql->addField('i', 'status', 'status');
		$sql->addField('i', 'created', 'created');
		
		/*search*/
		if($status != ''){
			$sql->condition('i.status', $status, '=');
		}

		$db_or = db_or();
		$db_or->condition('i.title', '%'.$keyword.'%', 'LIKE');
		$db_or->condition('i.title_alias', '%'.$keyword.'%', 'LIKE');
		$db_or->condition('i.content', '%'.$keyword.'%', 'LIKE');
		$sql->condition($db_or);
		/*end search*/

		if(isset($_GET['sort'])){
			$result = $sql->limit(SITE_RECORD_PER_PAGE)->orderByHeader($header)->execute();

		}else{
			$result = $sql->limit(SITE_RECORD_PER_PAGE)->orderBy('i.id', 'DESC')->orderBy('i.uid', 'DESC')->execute();
		}
		$arrItem = $result->fetchAll();

		//total item
		$totalItem = count($arrItem);
		$rows = array();
		if($totalItem > 0){

			$i=1;
			foreach ($arrItem as $row){
				$row = (object)$row;

				if($row->status==1){
					$status='<span class="bg-status-show">'.t('Hiện').'</span>';
				}else{
					$status='<span class="bg-status-hidden">'.t('Ẩn').'</span>';
				}

				$created = date('d-m-Y h:i',$row->created);

				if($row->focus==0){
					$focus = t('Tin thường');
				}else{
					$focus = '<span class="hot">'.t('Tin nổi bật').'</span>';
				}
				
				$rows[$i]['data']['checkbox'] = '<input type="checkbox" class="checkItem" name="checkItem[]" value="'.$row->id.'" />';
				$rows[$i]['data']['title'] = $row->title;
				$rows[$i]['data']['cat_name'] = $row->cat_name;
				$rows[$i]['data']['provice_name'] = $row->provice_name;
				$rows[$i]['data']['dictrict_name'] = $row->dictrict_name;
				$rows[$i]['data']['focus'] =  $focus;
				$rows[$i]['data']['created'] = $created;
				$rows[$i]['data']['status'] =  $status;

				$rows[$i]['data']['action'] = '<a class="icon huge" href="'.$base_url.'/admincp/estates/edit/'.$row->id.'"  title="Update Item">
											<i class="icon-pencil bgLeftIcon"></i>
										</a>
										<a class="icon huge" id="deleteOneItem" href="javascript:void(0)" title="Delete Item">
											<i class="icon-remove bgLeftIcon"></i>
										</a>';
				$i++;
			}
		}
		$listItem['table']['tablesort_table'] = array(
				'#theme' => 'table',
				'#header' => $header,
				'#rows' => $rows,
		);
		$listItem['pager'] = array('#theme' => 'pager','#quantity' => SITE_SCROLL_PAGE);

		return  $listItem;
	}

	function listInputForm(){

		$_Category = new _Category();
		
		$arrOptionsCategory[0] = t("--Chọn chuyên mục--");
		$_Type = new _Type();
		$typeid = $_Type->get_list_type_id($type_keyword='group_estates', $limit=1);
		$_Category->makeListCatFromType($typeid, 0, 0, $arrOptionsCategory, 20);

		$clsProvices = new _Provices();
		$arrOptionsProvice = $clsProvices->get_all_provices();
		$arrOptionsDictrict[0] = t("--Quận/huyện--");

		$type_unit = $_Type->get_list_type_id($type_keyword='group_unit', $limit=1);
		$_Category->makeListCatFromType($type_unit, 0, 0, $arrOptionsUnit, 20);

		$arr_fields = array(
				'id'=>array('type'=>'hidden', 'label'=>'', 'value'=>'0','require'=>'', 'attr'=>''),
				'uid'=>array('type'=>'hidden', 'label'=>'', 'value'=>'0','require'=>'', 'attr'=>''),
				'catid'=>array('type'=>'option', 'label'=>'Chuyên mục', 'value'=>'0','require'=>'require', 'attr'=>'','list_option'=>$arrOptionsCategory),
				'provice'=>array('type'=>'option', 'label'=>'Tỉnh/Thành', 'value'=>'0','require'=>'require', 'attr'=>'','list_option'=>$arrOptionsProvice),
				'dictrict'=>array('type'=>'option', 'label'=>'Quận/Huyện', 'value'=>'0','require'=>'require', 'attr'=>'','list_option'=>$arrOptionsDictrict),
				'title'=>array('type'=>'text', 'label'=>'Tiêu đề', 'value'=>'','require'=>'require', 'attr'=>''),
				'content'=>array('type'=>'textarea', 'label'=>'Nội dung', 'value'=>'', 'require'=>'require', 'attr'=>'', 'editor'=>1),
				'price'=>array('type'=>'text', 'label'=>'Giá', 'value'=>'','require'=>'', 'attr'=>''),
				'unit'=>array('type'=>'option', 'label'=>'Đơn vị', 'value'=>'0','require'=>'', 'attr'=>'','list_option'=>$arrOptionsUnit),
				'area'=>array('type'=>'text', 'label'=>'Diện tích', 'value'=>'','require'=>'', 'attr'=>''),
				'phone'=>array('type'=>'text', 'label'=>'Điện thoại', 'value'=>'','require'=>'', 'attr'=>''),
				'mail'=>array('type'=>'text', 'label'=>'Email', 'value'=>'','require'=>'', 'attr'=>''),
				'address'=>array('type'=>'text', 'label'=>'Địa chỉ', 'value'=>'','require'=>'', 'attr'=>''),
				'img'=>array('type'=>'file', 'label'=>'Ảnh đại diện', 'value'=>'','require'=>'', 'attr'=>''),
				/*field ajax upload muti img*/
				'txtImagesPost'=>array('type'=>'ajaxUploadMutiImg', 'label'=>'Ảnh slide', 'value'=>array(),'require'=>'', 'attr'=>''),
				
				'order_no'=>array('type'=>'text', 'label'=>'Số thứ tự', 'value'=>'1','require'=>'', 'attr'=>''),
				'focus'=>array('type'=>'option', 'label'=>'Nổi bật', 'value'=>'0', 'require'=>'' ,'attr'=>'','list_option'=>array('0'=>t('không'),'1'=>t('Có'))),
				'status'=>array('type'=>'option', 'label'=>'Trạng thái', 'value'=>'1', 'require'=>'' ,'attr'=>'','list_option'=>array('0'=>t('Ẩn'),'1'=>t('Hiện'))),
				
				//'language'=>array('type'=>'language', 'label'=>'Ngôn ngữ', 'value'=>'en', 'require'=>'' ,'attr'=>''),
				'meta_title'=>array('type'=>'textarea', 'label'=>'Meta title', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>0),
				'meta_keywords'=>array('type'=>'textarea', 'label'=>'Meta keywords', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>0),
				'meta_description'=>array('type'=>'textarea', 'label'=>'Meta description', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>0),
		);

		return $arr_fields;
	}
	
	function get_dictrict_id($estates_id=0){
		$dictrict_id=0;
		if($estates_id > 0){
			$arrItem = $this->getAll("dictrict", "id=$estates_id", "", "id ASC", 1);
			if(count($arrItem)>0){
				$dictrict_id = intval($arrItem[0]->dictrict);
			}
		}
		return $dictrict_id;
	}
}