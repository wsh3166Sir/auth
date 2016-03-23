<?php
$this->checklogin();
$uid = I("post.uid", 0, 'intval');
$Language = I('post.Language',0,'intval');
$type = I('post.type',0,'intval');
$cid = I('post.cid',0,'intval');
switch ($Language) {
	case 0:
		$fields = 'a.name,a.names,b.name as bname,a.keywords';
		$field = 'name,keywords';
		$catefield = 'title,address';
		$fieldss = 'a.name,a.names,a.names,b.name as bname';
		break;
	case 1:
		$fields = 'a.name_en,a.names_en,b.name_en as bname_en,a.keywords_en';
		$field = 'name_en,keywords_en';
		$catefield = 'title_en,address_en';
		$fieldss = 'a.name_en,a.names_en,a.names_en,b.name_en as bname_en';
		break;
	default:
		$this -> error(10205);
		break;
}
$where = array(
	'type' => $type,
	'uid'  => $uid
);
$group_id = M('collect')->where($where)->getField('uuid',true);
if(empty($group_id)){
	$this -> error(10214);
}
$where = array(
	'status' => 1,
	'id'     => array('in',$group_id)
);
switch ($type) {
	case 1:
		$list = M('exhibitors')->where($where)->field('id,thnum,'.$field)->select();
		foreach ($list as $key => &$value) {
			if($Language == 0){
				$value['keywords'] = explode(',', $value['keywords']);
			}else{
				$value['keywords'] = explode(',', $value['keywords_en']);
			}
		}
		unset($value);
		break;
	case 2:
		if($cid == 0){
			$this -> error(10215);
		}
		$where['cid'] =  $cid;
		$list = M('schedule')->where($where)->field('id,start_time,end_time,'.$catefield)->select();
		foreach ($list as $key => &$value) {
			$where = array(
				'sid' 	=> $value['id'],
				'type'  => $type
			);
			$idArr = M('schedule_user_index')->where($where)->getField('uid',true);
			$where = array(
				'a.id' 	 => array('in',$idArr),
				'a.status' => 1
			);
			$value['user'] = M()
			-> table('__USER__ a')
			-> join('LEFT JOIN __EXHIBITORS__ b ON a.units=b.id')
			-> field('a.id,'.$fieldss)
			-> where($where)
			-> select();
			foreach ($value['user'] as $k => &$v) {
				if($Language == 0){
					$v['name'] = $v['name'].$v['names'];
				}else{
					$v['name'] = $v['names_en'].$v['name_en'];
				}
			}
			unset($v);
		}
		unset($value);
		break;
	case 3:
		# code...
		break;
	default:	
		$where = array(
			'a.status' => 1,
			'a.id'     => array('in',$group_id)
		);	
		$list = M()
			-> table('__USER__ a')
			-> join('LEFT JOIN __EXHIBITORS__ b ON a.units=b.id')
			-> field('a.id,a.thnum,'.$fields)
			-> where($where)
			-> select();
		foreach ($list as $key => &$value) {
			if($Language == 0){
				$value['name'] = $value['name'].$value['names'];
				$value['keywords'] = explode(',', $value['keywords']);
			}else{
				$value['name'] = $value['name_en'].' '.$value['names_en'];
				$value['keywords'] = explode(',', $value['keywords_en']);
			}
		}
		unset($value);
			break;
}
$this -> success($list);