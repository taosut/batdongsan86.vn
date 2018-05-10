<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/

function indexCategory(){
	global $base_url;
	drupal_set_title(t('Danh mục'));
	$clsCategory = new _Category();
	
	$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
	$status = isset($_GET['status']) ? $_GET['status'] : '';
	
	$array_fields = array(
			'title'=>array('title'=>'Tiêu đề','attr'=>''),
			'type_id'=>array('title'=>'Kiểu nội dung','attr'=>'style="text-align: center"'),
			'menu'=>array('title'=>'Hiện ở menu','attr'=>'style="text-align: center"'),
			/*'language'=>array('title'=>'Ngôn ngữ','attr'=>'style="text-align: center"'),*/
			'order_no'=>array('title'=>'Thứ tự','attr'=>'style="text-align: center"'),
			'status'=>array('title'=>'Trạng thái','attr'=>'style="text-align: center"'),
			'created'=>array('title'=>'Ngày tạo','attr'=>'style="text-align: center"'),
			'action'=>array('title'=>'Action','attr'=>''),
	);

	$list_row = '';
	$total_item = 0;
	$clsCategory->getListCat(0, 0, $list_row, 100, 'admincp/category/edit', $total_item);
	$data = array(
			'title'=>'Quản lý danh mục',
			'array_fields'=>$array_fields,
			'list_row'=>$list_row,
			'total_item'=>$total_item,
			'keyword'=>$keyword,
			'status'=>$status,
	);

	$view = theme('category',$data);
	return $view;
}

function formCategoryAction(){
	global $base_url, $user;
	$clsStdio = new clsStdio();
	$clsCategory = new _Category();

	$arrOptionsCategory[0] = t("Danh mục gốc");
	$clsCategory->makeListCat(0, 0, $arrOptionsCategory, 50);
	
	$arrOptionsType = $clsCategory->get_option_type($limit=100);
	
	$arr_fields = array(
		'id'=>array('type'=>'hidden', 'label'=>'', 'value'=>'0','require'=>'', 'attr'=>''),
		'type_id'=>array('type'=>'option', 'label'=>'Nhóm nội dung', 'value'=>'0','require'=>'', 'attr'=>'','list_option'=>$arrOptionsType),
		'parent_id'=>array('type'=>'option', 'label'=>'Danh mục', 'value'=>'0','require'=>'', 'attr'=>'','list_option'=>$arrOptionsCategory),
		'title'=>array('type'=>'text', 'label'=>'Tiêu đề', 'value'=>'','require'=>'require', 'attr'=>''),
		'intro'=>array('type'=>'textarea', 'label'=>'Mô tả', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>0),
		'content'=>array('type'=>'textarea', 'label'=>'Nội dung', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>1),
		'order_no'=>array('type'=>'text', 'label'=>'Số thứ tự', 'value'=>'1','require'=>'', 'attr'=>''),
		'menu'=>array('type'=>'option', 'label'=>'Hiện ở menu ngang', 'value'=>'0', 'require'=>'' ,'attr'=>'','list_option'=>array('0'=>t('Ẩn'),'1'=>t('Hiện'))),
		'status'=>array('type'=>'option', 'label'=>'Trạng thái', 'value'=>'1', 'require'=>'' ,'attr'=>'','list_option'=>array('0'=>t('Ẩn'),'1'=>t('Hiện'))),
		//'language'=>array('type'=>'language', 'label'=>'Ngôn ngữ', 'value'=>'en', 'require'=>'' ,'attr'=>''),
		'meta_title'=>array('type'=>'textarea', 'label'=>'Meta title', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>0),
		'meta_keywords'=>array('type'=>'textarea', 'label'=>'Meta keywords', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>0),
		'meta_description'=>array('type'=>'textarea', 'label'=>'Meta description', 'value'=>'', 'require'=>'', 'attr'=>'', 'editor'=>0),
	);
	$fields = clsForm::buildItemFields($arr_fields);
	$data = array('fields'=>$fields);

	//check post: insert or update
	if(!empty($_POST) && $_POST['txtFormName']=='txtFormName'){
		$require_post = array();

		$data_post = array();
		$data_post['uid ']=$user->uid;
		$data_post['created']=time();
		$data_post['view_num'] = 0;

		foreach ($data['fields'] as $key => $field) {
			$data_post[$key] = clsForm::itemPostValue($key);
			$data['fields'][$key]['value']=$data_post[$key];

			if(isset($field['require']) && $field['require']=='require' && $data_post[$key]==''){
				$require_post[$key] = t($field['label']).' '.t('không được rỗng!');
			}

			if($key=='title'){
				$data_post['title_alias']=$clsStdio->pregReplaceStringAlias(clsForm::itemPostValue('title'));
			}
		}

		unset($_POST);
		if(count($require_post)>0){
			foreach ($require_post as $k => $v) {
				form_set_error($k, $v);
			}
			unset($data_post);
		}else{
			if($data['fields']['id']['value']>0){
				$query = $clsCategory->updateOne($data_post, $data['fields']['id']['value']);
				unset($data_post);
				drupal_set_message('Sửa bài viết thành công.');
				drupal_flush_all_caches();
				drupal_goto($base_url.'/admincp/category');
			}else{
				$query = $clsCategory->insertOne($data_post);
				unset($data_post);
				if($query){
					drupal_set_message('Thêm bài viết thành công.');
					drupal_flush_all_caches();
					drupal_goto($base_url.'/admincp/category');
				}
			}
		}
	}

	//get item update
	$param = arg();
	if(isset($param[2]) && isset($param[3]) && $param[2]=='edit' && $param[3]>0){
		$arrOneItem = $clsCategory->getOne("*", $param[3]);
		foreach ($data['fields'] as $key => $filed) {
			$data['fields'][$key]['value']=$arrOneItem[0]->$key;
		}
	}

	$view = theme('category-form',$data);
	return $view;
}

function deleteCategoryAction(){
	global $base_url;
	$clsCategory = new _Category();
	if(isset($_POST) && $_POST['txtFormName']=='txtFormName'){
		$listId = isset($_POST['checkItem'])? $_POST['checkItem'] : 0;
		foreach($listId as $item){
			if($item > 0){
				$query = $clsCategory->deleteOne($item);
			}
		}
		unset($listId);
		drupal_set_message('Xóa bài viết thành công.');
	}
	drupal_goto($base_url.'/admincp/category');
}