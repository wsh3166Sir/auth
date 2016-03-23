<?php
$this->checklogin();
$uid = I("post.uid", 0, 'intval');
$keywords = I('post.keywords');
$Language = I('post.Language',0,'intval');
switch ($Language) {
	case 0:
		$field='keywords';
		break;
	case 1:
		$field='keywords_en';
		break;
	default:
		$this -> error(10205);
		break;
}
$where = array(
	'uid'   => $uid,
	'statis'=> 1
);
$info = M('user')->where($where)->setField($field,$keywords);
if($info){
	$this -> success($info);
}else{
	$this -> error(10218);
}