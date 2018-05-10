<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
function get_list_item_estates($typeid=0, $catid=0){
	$arrItem = array();
	$listPage= array();
	$cat_name = '';
	if($typeid >0 && $catid > 0){
		$clsCategory = new Category();
		$clsEstates = new Estates();
		$param = arg();
		$cat_name_alias = trim($param[0]);
		$arrCat = $clsCategory->getCatFromAlias($cat_name_alias);
		$catid=0;
		$cat_name='';
		$cat_name_alias = '';
		$meta_title='';
		$meta_keywords='';
		$meta_description='';
		foreach($arrCat as $v){
			$catid = $v->id;
			$cat_name = $v->title;
			$cat_name_alias = $v->title_alias;
			
			$meta_title = $v->meta_title;
			$meta_keyword = $v->meta_keywords;
			$meta_description = $v->meta_description;

			$clsSeo = new clsSeo();
			$clsSeo->SEO($cat_name, '', $meta_title, $meta_keyword, $meta_description);
		}

		$arrCatid = $clsCategory->makeCatidQueryString($catid);
		
		$sql = db_select($clsEstates->table, 'i')->extend('PagerDefault');
		$sql->addField('i', 'id', 'id');
		$sql->addField('i', 'cat_alias', 'cat_alias');
		$sql->addField('i', 'title', 'title');
		$sql->addField('i', 'title_alias', 'title_alias');
		$sql->addField('i', 'content', 'content');
		$sql->addField('i', 'img', 'img');
		$sql->addField('i', 'area', 'area');
		$sql->addField('i', 'price', 'price');
		$sql->addField('i', 'created', 'created');
		$sql->addField('i', 'provice_name', 'title_provice');
		$sql->addField('i', 'dictrict_name', 'title_dictrict');
		$sql->addField('i', 'unit', 'unit');
		$sql->addField('i', 'focus', 'focus');
		$sql->condition('i.status', 1,'=');
		$sql->condition('i.catid', $arrCatid, 'IN');
		$sql->orderBy('i.focus', 'DESC');
		$sql->orderBy('i.id', 'DESC');
		$sql->orderBy('i.uid', 'ASC');
		$sql->limit(SITE_RECORD_PER_PAGE);
		
		$arrItem = $sql->execute()->fetchAll();
		$listPage['pager'] = array('#theme' => 'pager','#quantity' => 3);
	}
	$data = array(
				'arrItem'=>$arrItem,
				'listPage'=>$listPage,
				'cat_name'=>$cat_name,
			);
	$view = theme("page-estates", $data);
	return $view;
}
function get_item_estates_view($title_alias='', $catid=0){
	$cat_name='';
	
	if($title_alias != '' && $catid > 0){
		$clsCategory = new Category();
		$clsEstates = new Estates();
		$param = arg();
		$title_alias = trim($param[1]);
		$sql = db_select($clsEstates->table, 'i');

		$sql->addField('i', 'id', 'id');
		$sql->addField('i', 'catid', 'catid');
		$sql->addField('i', 'cat_name', 'cat_name');
		$sql->addField('i', 'cat_alias', 'cat_alias');
		
		$sql->addField('i', 'title', 'title');
		$sql->addField('i', 'title_alias', 'title_alias');
		$sql->addField('i', 'content', 'content');
		$sql->addField('i', 'img', 'img');
		$sql->addField('i', 'area', 'area');
		$sql->addField('i', 'price', 'price');
		$sql->addField('i', 'created', 'created');
		$sql->addField('i', 'unit', 'unit');
		$sql->addField('i', 'contact', 'contact');
		$sql->addField('i', 'mail', 'contact_mail');
		$sql->addField('i', 'phone', 'contact_phone');
		$sql->addField('i', 'provice_name', 'title_provice');
		$sql->addField('i', 'dictrict_name', 'title_dictrict');
		$sql->addField('i', 'subcat_name', 'title_category');
		$sql->addField('i', 'meta_title', 'meta_title');
		$sql->addField('i', 'meta_keywords', 'meta_keywords');
		$sql->addField('i', 'meta_description', 'meta_description');
		
		$sql->condition('i.title_alias', $title_alias, '=');
		$sql->condition('i.status', 1,'=');
		
		$sql->orderBy('i.id', 'DESC');
		$sql->range(0,1);
		$oneItem = $sql->execute()->fetchAll();
		

		$rs = db_select($clsEstates->table, 'i');
		
		$rs->addField('i', 'id', 'id');
		$rs->addField('i', 'cat_alias', 'cat_alias');
		$rs->addField('i', 'title', 'title');
		$rs->addField('i', 'title_alias', 'title_alias');
		$rs->addField('i', 'content', 'content');
		$rs->addField('i', 'img', 'img');
		$rs->addField('i', 'area', 'area');
		$rs->addField('i', 'price', 'price');
		$rs->addField('i', 'created', 'created');
		$rs->addField('i', 'provice_name', 'title_provice');
		$rs->addField('i', 'dictrict_name', 'title_dictrict');
		$rs->addField('i', 'unit', 'unit');
		$rs->addField('i', 'focus', 'focus');
		$rs->condition('i.status', 1,'=');
		$rs->condition('i.title_alias', $title_alias, '<>');
		$rs->condition('i.catid', $catid, '=');

		$rs->orderBy('i.focus', 'DESC');
		$rs->orderBy('i.id', 'DESC');

		$rs->range(0,15);
		$arrSameItem = $rs->execute()->fetchAll();
		$data = array(
			'oneItem'=>$oneItem,
			'arrSameItem'=>$arrSameItem,
			'cat_name'=>$cat_name,
		);

		$view = theme("page-estates-view", $data);
		return $view;
	}else{
		drupal_goto($base_url);
	}
}