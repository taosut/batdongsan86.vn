<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
function block_header(){
	global $base_url;
	$ads_header = get_ads_header();
	$list_menu = get_menu_header();
	$data = array(
				'list_menu'=>$list_menu,
				'ads_header'=>$ads_header,
			);
	$view= theme('block-header', $data);
	return $view;
}
function block_header_search(){
	$clsType = new Type();
	$clsCategory = new Category();
	$data = array(
				'clsType'=>$clsType,
				'clsCategory'=>$clsCategory,
			);
	$view= theme('block-header-search', $data);
	return $view;
}
function block_content_search_news(){
	
	$clsCategory = new Category();
	$clsEstates = new Estates();
	$clsProvices = new Provices();
	$clsDictricts = new Dictricts();
	$arrProvice = $clsProvices->list_category();

	$arrOptionsCategoryFull[0] = t("--Chọn loại nhà đất--");
	$typeid = 2;
	$clsCategory->makeListCatFromTypeFull($typeid, 0, 0, $arrOptionsCategoryFull, 20);

	$list_news_hot = get_news_item_hot();
	$data = array(	
				'list_news_hot'=>$list_news_hot,
				'arrProvice'=>$arrProvice,
				'arrOptionsCategoryFull'=>$arrOptionsCategoryFull,
			);
	$view= theme('block-content-search-news', $data);
	return $view;
}
function block_content_search_project(){
	$clsCategory = new Category();
	$clsEstates = new Estates();
	$clsProvices = new Provices();
	$clsDictricts = new Dictricts();
	$arrProvice = $clsProvices->list_category();

	$arrOptionsCategoryFull[0] = t("--Chọn loại nhà đất--");
	$typeid = 2;
	$clsCategory->makeListCatFromTypeFull($typeid, 0, 0, $arrOptionsCategoryFull, 20);

	$list_news_hot = get_news_item_hot();
	$data = array(	
				'list_news_hot'=>$list_news_hot,
				'arrProvice'=>$arrProvice,
				'arrOptionsCategoryFull'=>$arrOptionsCategoryFull,
			);
	$view= theme('block-content-search-project', $data);
	return $view;
}
function block_content_mid_ads(){
	$ads_middle = get_ads_middle();
	$data = array(
				'ads_middle'=>$ads_middle,
			);
	$view= theme('block-content-mid-ads',$data);
	return $view;
}
function block_content_post(){
	$list_estate = get_item_post_estates();
	$data = array(
				'list_estate'=>$list_estate,
			);
	$view= theme('block-content-post',$data);
	return $view;
}
function block_right_project(){
	$list_project_hot = get_item_right_project();
	$data = array(
				'list_project_hot'=>$list_project_hot,
			);
	$view= theme('block-right-project', $data);
	return $view;
}
function block_right_news(){
	$list_news_week = get_item_right_news();
	$data = array(
				'list_news_week'=>$list_news_week,
			);
	$view= theme('block-right-news', $data);
	return $view;
}
function block_right_advice(){
	$list_advice_hot = get_item_right_advice();
	$data = array(
				'list_advice_hot'=>$list_advice_hot,
			);
	$view= theme('block-right-advice', $data);
	return $view;
}
function block_right_statistic(){
	$view= theme('block-right-statistic');
	return $view;
}
function block_footer_us(){
	$view= theme('block-footer-us');
	return $view;
}
function block_footer_link(){
	
	$view= theme('block-footer-link');
	return $view;
}
function block_footer(){
	global $base_url;
	
	$view= theme('block-footer');
	return $view;
}