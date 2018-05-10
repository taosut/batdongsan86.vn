<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
class Users extends DbBasic{

	function __construct(){
        $this->pkey = 'uid';
        $this->table = 'users';

    }
}





