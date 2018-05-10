<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
function block_content(){
	clsSeo::SEO(
				$title='Đồng hồ nam giá rẻ', 
				$img='', 
				$meta_title='Đồng hồ nam giá rẻ', 
				$meta_keyword='Đồng hồ nam giá rẻ, dong ho nam gia re', 
				$meta_description='Với phương châm LUÔN KHÁC BIỆT & VƯỢT TRỘI lần này Đồng hồ rẻ đẹp .COM mang đến cho quý khách một chương trình khuyến mại CỰC KHỦNG MUA 1 TẶNG 1 Giảm giá tới 50% ĐỒNG GIÁ 299.000đ'
			);
	$clsAds = new Ads();
	$arrAds = $clsAds->getAll("*", "status=1 AND pos=1", "", "id ASC", "1");
	$arrProduct = get_all_product();
	
	$data = array(
				'arrAds' => $arrAds,
				'arrProduct'=>$arrProduct,
			);
	$view = theme('page-default',$data);
	return $view;
}

function get_all_product(){
	$clsProduct = new Product();
	$arrItem = $clsProduct->getAll("id, title, intro, content, img", "status=1", "", "order_no ASC", "50");
	return $arrItem;
}
function get_all_img($pid=0){
	$arrImg = array();
	if($pid > 0){
		$clsProductImg = new ProductImg();
		$arrImg = $clsProductImg->getAll("path", "type='p' and status=1 and pid=".$pid, "", "id ASC", "6");
	}
	return $arrImg;
}
function get_all_gift($pid=0){
	$arrImg = array();
	if($pid > 0){
		$clsProductImg = new ProductImg();
		$arrImg = $clsProductImg->getAll("path", "type='g' and status=1 and pid=".$pid, "", "id ASC", "6");
	}
	return $arrImg;
}

function orderPost(){
	global $base_url;
	if(isset($_POST) && !empty($_POST)){
		$pId = isset($_POST['pid'])	? intval($_POST['pid']) 	: 0;
		$txtName 	= isset($_POST['txtName'])		? trim($_POST['txtName']) 	 : '';
		$txtPhone 	= isset($_POST['txtPhone'])	? trim($_POST['txtPhone']) 	 : '';
		$txtAddress 	= isset($_POST['txtAddress'])	? trim($_POST['txtAddress']) 	 : '';
		$txtNote 	= isset($_POST['txtNote'])	? trim($_POST['txtNote']) 	 : '';
		
		if($txtName!='' && $txtPhone!='' && $pId>0){
			#send mail
			$clsProduct = new Product();
			$arrItem = $clsProduct->getAll("id, title", "status=1", "", "order_no ASC", "1");
			if(count($arrItem )>0){
				$title =  $arrItem[0]->title;
				$html = '<div><h2>Thông tin đơn hàng:</h2></div><br/>';
				$html .= '<div>Mua sản phẩm: '.$title.'</div><br/>';
				$html .= '<div>Họ tên: '.$txtName.'</div><br/>';
				$html .= '<div>Điện thoại: '.$txtPhone.'</div><br/>';
				$html .= '<div>Địa chỉ: '.$txtAddress.'</div><br/>';
				$html .= '<div>Ghi chú: '.$txtNote.'</div><br/>';
				$html .= '<div>(Đăng ký lúc: '.date('d/m/Y - h:i', time()).')</div>';

				$key = $html;
		        $to = "duynx@hanelsoft.vn";
		        $from='';
		        $params = "Thông tin đặt hàng từ website ".$base_url;
		        $language = language_default();
		        $send = true;
		        $send_mail = drupal_mail("HSSPageStatics", $key, $to, $language, $params, $from, $send);
			}
			unset($_POST);
			echo 'sendmail_ok';
		}else{
			unset($_POST);
			echo 'sendmail_notok';
		}
	}
}

function sendmail(){
	orderPost();
}