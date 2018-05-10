<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
function get_menu_header(){
	$clsCategory = new Category();
	$arrListMenu= array();
	$arrListMenu = $clsCategory->getAll("id, parent_id, type_id, title, title_alias", "(type_id=2 OR type_id=3) AND status=1 AND parent_id=0 AND menu=1", "", "order_no ASC", "10");
	return $arrListMenu;
}
function get_sub_menu($catid=0){
	$clsCategory = new Category();
	$arrListMenuSub = array();
	if($catid>0){
		$arrListMenuSub = $clsCategory->getAll("id, parent_id, title, title_alias", "(type_id=2 OR type_id=3) AND status=1 AND menu=1 AND parent_id=$catid", "", "order_no ASC", "20");
	}
	return $arrListMenuSub;
}

function get_ads_header(){
	$clsAds = new Ads();
	$arrItem = $clsAds->getAll("id, title_show, link, img", "status=1 AND pos=1", "", "id DESC", "1");
	return $arrItem;
}
function get_ads_middle(){
	$clsAds = new Ads();
	$arrItem = $clsAds->getAll("id, title_show, link, img", "status=1 AND pos=2", "", "id DESC", "1");
	return $arrItem;
}

function get_item_post_estates(){
	$clsEstates = new Estates();

	$rs = db_select($clsEstates->table, 'i')->extend('PagerDefault');
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
	$rs->condition('i.focus', 1,'=');
	$rs->orderBy('i.focus', 'DESC');
	$rs->orderBy('i.id', 'DESC');
	$rs->orderBy('i.uid', 'ASC');
	#$rs->range(0,15);
	$rs->limit(15);
	$arrItem['item'] = $rs->execute()->fetchAll();
	$arrItem['pager'] = array('#theme' => 'pager','#quantity' => 3);
	return $arrItem;
}

function get_item_right_project(){

	$clsNews = new News();
	$arrItem = $clsNews->getAll("id, title, title_alias, cat_alias, img", "status=1 AND cat_alias='du-an' AND focus=1 ", "", "order_no DESC", "5");
	return $arrItem;
}

function get_item_right_advice(){

	$clsNews = new News();
	$arrItem = $clsNews->getAll("id, title, title_alias, cat_alias, img", "status=1 AND cat_alias='loi-khuyen' AND focus=1 ", "", "id DESC", "10");
	return $arrItem;
}

function get_item_right_news(){

	$clsNews = new News();
	$arrItem = $clsNews->getAll("id, title, title_alias, cat_alias, img", "status=1  AND focus=1 ", "", "id DESC", "10");
	return $arrItem;
}

function get_news_item_hot(){

	$clsNews = new News();
	$arrItem = $clsNews->getAll("id, title, title_alias, cat_alias, img, intro", "status=1  AND hot=1 ", "", "id DESC", "6");
	return $arrItem;
}