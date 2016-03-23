<?php
$this->checklogin(); 
$list = C('CONTACTS_CONFIG');
if(empty($list)){
	$this -> error(10208);
}
$this -> success($list);