<?php
$id = I('post.id',0,'intval');
$cid= I('post.cid',0,'intval');
$uid= I('post.uid',0,'intval');
$pagenum    = I('post.pagenum',1,'intval');
$page    = I('post.page',10,'intval');
if(empty($id)){
	$this -> error(10202);
}
$Language = I('post.Language',0,'intval');
switch ($Language) {
	case 0:
		$field='name,keywords';
		break;
	case 1:
		$field='name_en,keywords_en';
		break;
	default:
		$this -> error(10205);
		break;
}
$where = array(
	'cate_type' => 1,
	'id'=> $id,
	'status'   => 1
);

$list['data'] = M('exhibitors')->where($where)->field('id,thnum,'.$field)->order('sort DESC')->limit(($page-1)*$pagenum, $pagenum)->select();
foreach ($list['data'] as $key => &$value) {
	if($Language == 0){
		$value['keywords'] = explode(',', $value['keywords']);
	}else{
		$value['keywords_en'] = explode(',', $value['keywords_en']);
	}
	if($uid != 0){
		$where = array(
			'uid'  => $uid,
			'uuid' => $value['id'],
			'type' => 1,
		);
		$res = M('collect')->where($where)->getField('uid');
		if($res){
			$value['collect'] = 1;
		}else{
			$value['collect'] = 0;
		}
	}else{
		$value['collect'] = 0;
	}
}
unset($value);
$list['cid'] = $cid;
$this -> success($list);