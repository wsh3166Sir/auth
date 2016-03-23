<?php
//语言 0 中文 1英文
$Language = I('post.Language',0,'intval');
//获取分类标题
$where = array(
	'status' => 1,
	'display'=> 1,
	'pid'    => array('neq',0)
);
switch ($Language) {
	case 0:
		$field='title';
		break;
	case 1:
		$field='title_en';
		break;
	default:
		$this -> error(10205);
		break;
}

$data = M('article_cate')->where($where)->field('id,cate_type,'.$field)->order('sort ASC')->select();
if(empty($data)){
	$this -> error();
}
$this -> success($data);
