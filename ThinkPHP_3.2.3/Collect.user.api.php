<?php
$this->checklogin();
$uid = I("post.uid", 0, 'intval');
$id = I("post.id", 0, 'intval');
$type = I('post.type',0,'intval');
if(empty($id)){
	$this -> error(10206);
}
$where = array(
	'uid' => $uid,
	'uuid'=> $id,
	'type'=> $type
);
$model = M('collect');
$res = $model ->where($where)->find();
if($res){
	$res = $model -> where($where)->delete();
	if(!$res){
		$this -> error(10207);
	}
}else{
	$res = $model -> add($where);
	if(!$res){
		$this -> error(10207);
	}
}
$this -> success($res);