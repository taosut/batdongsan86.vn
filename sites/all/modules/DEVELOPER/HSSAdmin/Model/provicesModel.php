<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
class _Provices extends Provices{

	function listItemPost(){
		global $base_url;

		$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
		$status = isset($_GET['status']) ? $_GET['status'] : '';

		$header = array(
				array('data' => '<input type="checkbox" id="checkAll"/>'),
				array('field' => 'i.title','data' => t('Tỉnh thành')),
				array('field' => 'i.created','data' => t('Ngày tạo')),
				array('field' => 'i.order_no','data' => t('Thư tự')),
				array('field' => 'i.status','data' => t('Trạng thái')),
				array('data' => t('Action'))
		);

		$sql = db_select($this->table, 'i')->extend('PagerDefault')->extend('TableSort');

		$sql->addField('i', 'id', 'id');
		$sql->addField('i', 'title', 'title');
		$sql->addField('i', 'created', 'created');
		$sql->addField('i', 'order_no', 'order_no');
		$sql->addField('i', 'status', 'status');

		/*search*/
		if($status != ''){
			$sql->condition('i.status', $status, '=');
		}

		$db_or = db_or();
		$db_or->condition('i.title', '%'.$keyword.'%', 'LIKE');
		$db_or->condition('i.title_alias', '%'.$keyword.'%', 'LIKE');
		$db_or->condition('i.intro', '%'.$keyword.'%', 'LIKE');
		$db_or->condition('i.content', '%'.$keyword.'%', 'LIKE');
		$sql->condition($db_or);
		/*end search*/

		if(isset($_GET['sort'])){
			$result = $sql->limit(SITE_RECORD_PER_PAGE)->orderByHeader($header)->execute();

		}else{
			$result = $sql
			->limit(SITE_RECORD_PER_PAGE)->orderBy('i.order_no', 'ASC')->execute();
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

				$rows[$i]['data']['checkbox'] = '<input type="checkbox" class="checkItem" name="checkItem[]" value="'.$row->id.'" />';
				$rows[$i]['data']['title'] = $row->title;
				$rows[$i]['data']['created'] = $created;
				$rows[$i]['data']['order_no'] =  $row->order_no;
				$rows[$i]['data']['status'] =  $status;

				$rows[$i]['data']['action'] = '<a class="icon huge" href="'.$base_url.'/admincp/provices/edit/'.$row->id.'"  title="Update Item">
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

		$arr_fields = array(
				'id'=>array('type'=>'hidden', 'label'=>'', 'value'=>'0','require'=>'', 'attr'=>''),
				'title'=>array('type'=>'text', 'label'=>'Tiêu đề', 'value'=>'','require'=>'require', 'attr'=>''),
				'intro'=>array('type'=>'textarea', 'label'=>'Mô tả', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>0),
				'content'=>array('type'=>'textarea', 'label'=>'Nội dung', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>1),
				//'img'=>array('type'=>'file', 'label'=>'Ảnh', 'value'=>'','require'=>'', 'attr'=>''),
				'order_no'=>array('type'=>'text', 'label'=>'Số thứ tự', 'value'=>'1','require'=>'', 'attr'=>''),
				//'focus'=>array('type'=>'option', 'label'=>'Nổi bật', 'value'=>'0', 'require'=>'' ,'attr'=>'','list_option'=>array('0'=>t('không'),'1'=>t('Có'))),
				'status'=>array('type'=>'option', 'label'=>'Trạng thái', 'value'=>'1', 'require'=>'' ,'attr'=>'','list_option'=>array('0'=>t('Ẩn'),'1'=>t('Hiện'))),
				//'language'=>array('type'=>'language', 'label'=>'Ngôn ngữ', 'value'=>'en', 'require'=>'' ,'attr'=>''),
				//'meta_title'=>array('type'=>'textarea', 'label'=>'Meta title', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>0),
				//'meta_keywords'=>array('type'=>'textarea', 'label'=>'Meta keywords', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>0),
				//'meta_description'=>array('type'=>'textarea', 'label'=>'Meta description', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>0),
		);

		return $arr_fields;
	}
}