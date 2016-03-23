<?php
$this->checklogin();
$uid = I("post.uid", 0, 'intval');
$id  = I("post.id",0,'intval');
$where = array(
	'id' 	=> $uid,
	'status'=> 1
);
$model = M('user');
$owner_username = $model -> where($where)->getField('member');
if(empty($owner_username)){
	$this -> error(10210);
}
$where = array(
	'id' 	=> $id,
	'status'=> 1
);
$friend_username  = $model -> where($where)->getField('member');
if(empty($friend_username)){
	$this -> error(10211);
}
require('./Application/Common/Lib/Hxcall.class.php');
$rs = new \Hxcall();
$res = $rs->hx_contacts($owner_username,$friend_username);
if($res){
	$this -> success();
}else{
	$this -> error(10212);
}