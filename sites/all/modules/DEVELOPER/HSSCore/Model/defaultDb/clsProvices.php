<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/

class Provices extends DbBasic{

    function __construct(){
        $this->pkey = 'id';
        $this->table = 'hss_provices';
    }
	function get_name_provices($id=0){
		$arrName = $this->getByCond("title", "id = $id", "", "", "1");
		$html='';
		foreach($arrName as $v){
			$html .= $v->title;
		}
		return $html;	
	}
	function get_name_provices_from_alias($str=''){
		$arrProvice = array();
		if($str!=''){
			$arrProvice = $this->getByCond("id, title, title_alias", "title_alias = '".$str."'", "", "", "1");
		}
		return $arrProvice;	
	}
	
	//list provices
	function list_category($_catid=0){
		
		$arrListCat = $this->getAll("id,title", "status=1", "", "id ASC", "100");
		$option='';
		foreach($arrListCat as $catid){
			//catid
			$selected = 'selected="selected"';
			if($catid->id > 0){
				if($catid->id==$_catid){
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
	function get_all_provices(){
		$arrItem = $this->getByCond("id, title", "status=1", "", "", "");
		$arrOptions = array();
		foreach($arrItem as $v){
			$arrOptions[$v->id] = $v->title;
		}
		return $arrOptions;	
	}

	function get_one_provice_from_catid($catid=0){
    	$arrCat = array();
    	if($catid > 0){
    		$arrCat = $this->getAll("title, title_alias", "id=$catid", "", "id ASC", "1");
    	}
    	return $arrCat;
    }
}