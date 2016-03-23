<?php
$this->checklogin();
$pagenum    = I('post.pagenum',1,'intval');
$page    = I('post.page',10,'intval');
$where = array(
	'status' => 1,
);
$list = M('recording')->where($where)->field('id,title,thnum')->limit(($page-1)*$pagenum, $pagenum)->select();
$this -> success($list);