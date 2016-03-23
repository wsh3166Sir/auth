<?php
$this->checklogin();
$uid = I("post.uid", 0, 'intval');
$Language = I('post.Language',0,'intval');
switch ($Language) {
	case 0:
		$catefield = 'title';
		break;
	case 1:
		$catefield = 'title_en';
		break;
	default:
		$this -> error(10205);
		break;
}
$map = array(
	'display' => 1,
	'cate_type'=>0,
	'status' => 1
);
$list = M('article_cate')->where($map)->field('id,'.$catefield)->select();
$this -> success($list);