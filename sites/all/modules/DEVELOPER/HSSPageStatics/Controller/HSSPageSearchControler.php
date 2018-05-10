<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
function search_item_header(){
	$keyword = isset($_GET['txtKeyword']) ? trim($_GET['txtKeyword']) : '';
	$catid = isset($_GET['txtCat']) ? trim($_GET['txtCat']) : '';
	if($keyword != '' && $catid > 0){
		//get type id
		$clsCategory = new Category();
		$arrCat = $clsCategory->getByCond("type_id", "id='".$catid."'", "", "id ASC", "1");
		if($arrCat[0]->type_id == 2){
			return search_estates($keyword, $catid);
		}else{
			return search_news($keyword, $catid);
		}
	}
}
function search_estates($keyword='', $catid=0){
	$arrItem = array();
	$listPage = array();
	
	if($catid > 0){
		$clsCategory = new Category();
		$clsEstates = new Estates();
		$arrCatid = $clsCategory->makeCatidQueryString($catid);
		
		$clsSeo = new clsSeo();
		$clsSeo->SEO('Tìm kiếm', '', 'Tìm kiếm', 'Tìm kiếm', 'Tìm kiếm');

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
		$db_or = db_or();
		$db_or->condition('i.title', '%'.$keyword.'%', 'LIKE');
		$db_or->condition('i.title_alias', '%'.$keyword.'%', 'LIKE');
		$sql->condition($db_or);

		$sql->orderBy('i.focus', 'DESC');
		$sql->orderBy('i.id', 'DESC');
		$sql->limit(SITE_RECORD_PER_PAGE);
		
		$arrItem = $sql->execute()->fetchAll();
		$listPage['pager'] = array('#theme' => 'pager','#quantity' => 3);
	}
	$data = array(
			'arrItem'=>$arrItem,
			'listPage'=>$listPage,
			);
	$view = theme('page-search-estates', $data);
	return $view;
}
function search_news($keyword='', $catid=0){
	$arrItem = array();
	$listPage= array();

	if($catid > 0){
		$clsCategory = new Category();
		$clsNews = new News();
		$arrCatid = $clsCategory->makeCatidQueryString($catid);
		
		$clsSeo = new clsSeo();
		$clsSeo->SEO('Tìm kiếm', '', 'Tìm kiếm', 'Tìm kiếm', 'Tìm kiếm');

		$sql = db_select($clsNews->table, 'i')->extend('PagerDefault');
		$sql->addField('i', 'id', 'id');
		$sql->addField('i', 'catid', 'catid');
		$sql->addField('i', 'cat_alias', 'cat_alias');
		$sql->addField('i', 'title', 'title');
		$sql->addField('i', 'title_alias', 'title_alias');
		$sql->addField('i', 'intro', 'intro');
		$sql->addField('i', 'img', 'img');
		$sql->addField('i', 'created', 'created');
		
		$sql->condition('i.catid', $arrCatid, 'IN');

		$db_or = db_or();
		$db_or->condition('i.title', '%'.$keyword.'%', 'LIKE');
		$db_or->condition('i.title_alias', '%'.$keyword.'%', 'LIKE');
		$sql->condition($db_or);

		$sql->condition('i.status', 1,'=');		
		$sql->orderBy('i.id', 'DESC');
		$sql->limit(SITE_RECORD_PER_PAGE_NEWS);
		$arrItem = $sql->execute()->fetchAll();
		$listPage['pager'] = array('#theme' => 'pager','#quantity' => 3);
	}
	$data = array(
				'arrItem'=>$arrItem,
				'listPage'=>$listPage,
			);
	$view = theme("page-search-news", $data);
	return $view;
}
function search_item_full(){
	$txtKeyword = isset($_GET['txtKeyword']) ? trim($_GET['txtKeyword']) : '';
	$catid = isset($_GET['txtCat']) ? trim($_GET['txtCat']) : 0;
	$txtProvice = isset($_GET['txtProvice']) ? trim($_GET['txtProvice']) : 0;
	$txtDictrict = isset($_GET['txtDictrict']) ? trim($_GET['txtDictrict']) : 0;
	$txtArea = isset($_GET['txtArea']) ? trim($_GET['txtArea']) : 0;
	$txtPrice = isset($_GET['txtPrice']) ? trim($_GET['txtPrice']) : 0;
	
	
	$clsCategory = new Category();
	$clsEstates = new Estates();
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
	
	if($catid > 0){
		$arrCatid = $clsCategory->makeCatidQueryString($catid);
		$sql->condition('i.catid', $arrCatid, 'IN');
	}
	if($txtProvice>0){
		$sql->condition('i.provice', $txtProvice, '=');
	}
	if($txtDictrict>0){
		$sql->condition('i.dictrict', $txtDictrict, '=');
	}

	$db_or = db_or();
	$db_or->condition('i.title', '%'.$txtKeyword.'%', 'LIKE');
	$db_or->condition('i.title_alias', '%'.$txtKeyword.'%', 'LIKE');
	$sql->condition($db_or);

	$sql->orderBy('i.focus', 'DESC');
	$sql->orderBy('i.id', 'DESC');
	$sql->limit(SITE_RECORD_PER_PAGE);
	
	$arrItem = $sql->execute()->fetchAll();
	$listPage['pager'] = array('#theme' => 'pager','#quantity' => 3);
	
	
	$data = array(
			'arrItem'=>$arrItem,
			'listPage'=>$listPage,
			);
	$view = theme('page-search-estates', $data);
	return $view;
}