<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
class Estates extends DbBasic{

    function __construct(){
        $this->pkey = 'id';
        $this->table = 'hss_estates';
    }
}

class Img extends DbBasic{

    function __construct(){
        $this->pkey = 'id';
        $this->table = 'hss_estates_img';
    }
}


