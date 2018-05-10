<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/

class Dictricts extends DbBasic{

    function __construct(){
        $this->pkey = 'id';
        $this->table = 'hss_dictricts';
    }
	
	function list_dictricts($_catid, $dictrict_id=0){
		$arrListCat = $this->getAll("id,title", "status=1 AND provice_id=$_catid", "", "id ASC", "100");
		$option='';
		$option .= '<option value="0">-- Quận/huyện --</option>';
		foreach($arrListCat as $catid){
			$selected = 'selected="selected"';
			if($catid->id > 0){
				if($catid->id==$dictrict_id){
					$option .= '<option value="'.$catid->id.'"'.$selected.'>'.$catid->title.'</option>';
				}else{
					$option .= '<option value="'.$catid->id.'">'.$catid->title.'</option>';
				}	
			}	
		}
		$html='';
		$html.= $option;
		
		return $html;
	}
	function get_name_dictrict($id=0){
		$arrName = $this->getByCond("title", "id = $id", "", "", "1");
		$html='';
		foreach($arrName as $v){
			$html .= $v->title;
		}
		return $html;	
	}

	function get_one_dictrict_from_catid($catid=0){
    	$arrCat = array();
    	if($catid > 0){
    		$arrCat = $this->getAll("title, title_alias", "id=$catid", "", "id ASC", "1");
    	}
    	return $arrCat;
    }
}