<?php
$id       = I('post.id',0,'intval');
$uid       = I('post.uid',0,'intval');
$pagenum    = I('post.pagenum',1,'intval');
$page    = I('post.page',10,'intval');
if(empty($id)){
	$this -> error(10204);
}
$Language = I('post.Language',0,'intval');
switch ($Language) {
	case 0:
		$field = 'name,keywords,desc,area';
		$fieldName = 'name';
		break;
	case 1:
		$field = 'name_en,keywords_en,desc_en,area_en';
		$fieldName = 'name_en';
		break;
	default:
		$this -> error(10205);
		break;
}
$where = array(
	'id' => $id,
	'status'   => 1
);
$list = M('exhibitors')->where($where)->field('id,thnum,twitter,facebook,linkedin,weibo,web,WeChat,emails,country,'.$field)->limit(($page-1)*$pagenum, $pagenum)->select();
foreach ($list as $key => &$value) {
	$where = array(
		'id' => $value['country']
	);
	$value['country']= M('city')->where($where)->getField($fieldName);
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
	if($Language == 0){
		$value['keywords'] = explode(',', $value['keywords']);
	}else{
		$value['keywords'] = explode(',', $value['keywords_en']);
	}
	$where = array(
		'sid' => $id,
	);
	$group_id = M('exhibitors_user_index')->where($where)->getField('uid',true);
	$where = array(
		'status' => 1,
		'id'     => array('in',$group_id)
	);
	$value['user'][] = M('user')->where($where)->field('id,thnum')->select();
}
unset($value);
$this -> success($list);