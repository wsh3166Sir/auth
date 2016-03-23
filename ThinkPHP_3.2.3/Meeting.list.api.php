<?php
$id = I('post.id',0,'intval');
$uid = I('post.uid',0,'intval');
$pagenum    = I('post.pagenum',1,'intval');
$page    = I('post.page',10,'intval');
if(empty($id)){
	$this -> error(10203);
}
$Language = I('post.Language',0,'intval');
switch ($Language) {
	case 0:
		$field='a.title,a.address';
		$fields = 'a.name,a.names,b.name as baname';
		break;
	case 1:
		$field='a.title_en,a.address_en';
		$fields = 'a.name_en,a.names_en,b.name_en as bname_en';
		break;
	default:
		$this -> error(10205);
		break;
}
$where = array(
	'a.status'	=> 1,
	'b.cate_type' => 0,
	'b.id'        => $id
);
$list = M()
	-> table('__SCHEDULE__ a')
	-> join('LEFT JOIN __ARTICLE_CATE__ b ON a.cid=b.id')
	-> field('a.id,a.start_time,a.end_time,'.$field)
	-> where($where)
	->limit(($page-1)*$pagenum, $pagenum)
	-> select();
foreach ($list as $key => &$value) {
	$where = array(
		'sid' => $value['id'],
	);
	$group_id = M('schedule_user_index')->where($where)->getField('uid',true);
	if(!empty($group_id)){
		$where = array(
			'a.status' => 1,
			'a.id'     => array('in',$group_id)
		);
		$value['user'] =M()
				-> table('__USER__ a')
				-> join('LEFT JOIN __EXHIBITORS__ b ON a.units=b.id')
				-> field('a.id,'.$fields)
				-> where($where)
				-> select();
		foreach ($value['user'] as $k => &$v) {
			if($Language == 0){
				$v['name'] = $v['name'].$v['names'];
			}else{
				$v['name'] = $v['name_en'].' '.$v['names_en'];
			}
		}
		unset($v);
	}
	if($uid != 0){
		$where = array(
			'uid'  => $uid,
			'uuid' => $value['id'],
			'type' => 2,
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
	$this -> assign($value['user']);
	if(empty($value['user'])){
		$value['user'] = array();
	}
}
unset($value);
if(empty($list)){
	$this -> success();
}
$this -> success($list);