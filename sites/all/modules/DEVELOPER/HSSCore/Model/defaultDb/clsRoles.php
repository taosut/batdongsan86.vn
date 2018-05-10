<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 06/2014
* @Version	 : 1.0
*/
class Roles extends DbBasic{

	function __construct(){
        $this->pkey = 'rid';
        $this->table = 'role';

    }
}

class UsersRoles extends DbBasic{

	function __construct(){
        $this->pkey = 'rid';
        $this->table = 'users_roles';

    }
}




