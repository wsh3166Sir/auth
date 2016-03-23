<?php
//语言 0 中文 1英文
$Language = I('post.Language',0,'intval');
//获取分类标题
$where = array(
	'status' => 1,
	'display'=> 1,
	'pid'    => 0
);
switch ($Language) {
	case 0:
		$name='title';
		break;
	case 1:
		$name='title_en';
		break;
	default:
		$this -> error(10205);
		break;
}
$data['index_title'] = M('article_cate')->field('id,'.$name)->where($where)->find();
$this -> success($data);
