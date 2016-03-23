<?php
$this->checklogin();
$uid = I("post.uid", 0, 'intval');
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
$info = M('user')->where($where)->getField($field);
$this -> success($info);