<?php
$this->checklogin();
$uid = I('post.uid',0,'intval');
$password = I('post.password');
$newpwd = I('post.newpwd');
$renewpwd = I('post.renewpwd');
if($newpwd !== $renewpwd){
	$this -> error(10216);
}
$where = array(
	'password' => md5($password),
	'id'       => $uid,
	'status'   => 1
);
$res = M('user')->where($where)->getField('id');
if($res){
	$where = array(
		'status' => 1,
		'id'=>$uid,
	);
	$res = M('user')->where($where)->setField('password',md5($newpwd));
	if($res){
		$this -> success();
	}
}else{
	$this -> error(10217);
}