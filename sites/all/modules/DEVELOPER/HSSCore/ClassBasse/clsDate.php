<?php 
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0 
*/
class clsDate{
	
	/*--------------------------------------convert date to int---------------------------------------------------*/
	public function convertDate($date=''){
		if($date!=''){
			$date = str_replace('/', '-', $date);
			$strtotime = strtotime($date);
			return $strtotime;
		}
		return time();
	}
	
	/*--------------------------------------show date to string---------------------------------------------------*/
	public function showDate($date){
		$_date='';
		if($date){
			$_date = date('d/m/Y', intval($date));
			return $_date;
		}
		return date('d/m/Y', time());
	}
	
	/*--------------------------------------date vietnamese convert------------------------------------------------*/
	 public function date_vietname($str=''){
	 	$current_date_str='';
		$arrListTodayVietnamese = array("Mon" => "Thứ hai","Tue" => "Thứ ba","Wed" => "Thứ tư","Thu" => "Thứ năm","Fri" => "Thứ sáu","Sat" => "Thứ bảy","Sun" => "Chủ nhật");
	 	foreach($arrListTodayVietnamese as $k => $v){
			if(strtolower($str)===strtolower($k)){
				$current_date_str = $v;
			}
		 }
		 return $current_date_str;
	 }
}
