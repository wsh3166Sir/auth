<?php
$id       = I('post.id',0,'intval');
$uid      = I('post.uid',0,'intval');
if(empty($id)){
	$this -> error(10204);
}
$Language = I('post.Language',0,'intval');
switch ($Language) {
	case 0:
		$field = 'name,names,positions,keywords,desc,area';
		$valuename = 'name';
		$fields = 'title,address';
		$uaerinfo = 'a.name,a.names,b.name as bname';
		$fieldName = 'name';
		break;
	case 1:
		$field = 'name_en,names_en,positions_en,keywords_en,desc_en,area_en';
		$valuename = 'name_en';
		$fields = 'title_en,address_en';
		$uaerinfo = 'a.name_en,a.names_en,b.name_en,bname_en';
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
$list = M('user')->where($where)->field('id,thnum,units,twitter,facebook,linkedin,weibo,web,WeChat,emails,country,'.$field)->select();
foreach ($list as $key => &$value) {
	if($uid != 0){
		$where = array(
			'uid'  => $uid,
			'uuid' => $value['id'],
			'type' => 0,
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
	$where = array(
		'id' => $value['country']
	);
	$value['country'] = M('city')->where($where)->getField($fieldName);
	if($Language == 0){
		$value['keywords'] = explode(',', $value['keywords']);
		$value['name'] = $value['name'].' '.$value['names'];
	}else{
		$value['keywords'] = explode(',', $value['keywords_en']);
		$value['name'] = $value['names_en'].' '.$value['name_en'];
	}
	$where = array(
		'id' => $value['units'],
		'status' => 1
	);
	$value['units'] = M('exhibitors')->where($where)->getField($valuename);
	$where = array(
		'uid' => $id,
	);
	$group_id = M('schedule_user_index')->where($where)->group('sid')->getField('sid',true);
	if($group_id){
		$where = array(
			'status' => 1,
			'id'     => array('in',$group_id)
		);
		$value['speech'] = M('schedule')->where($where)->field('id,time,start_time,end_time,'.$fields)->select();
		foreach ($value['speech'] as $k => $v) {
			$where = array(
				'sid' => $v['id']
			);
			$userArr = M('schedule_user_index')->where($where)->getField('uid',true);
			$where = array(
				'a.id'    => array('in',$userArr),
				'a.status'=>1,
			);
			$value['speech'][$k]['userinfo'] = M()
				-> table('__USER__ a')
				-> join('LEFT JOIN __EXHIBITORS__ b ON a.units=b.id')
				-> field('a.id,'.$uaerinfo)
				-> where($where)
				-> select();
			foreach ($value['speech'][$k]['userinfo'] as $keys => &$values) {
				if($Language == 0){
					$values['name'] = $values['name'].$values['names'];
				}else{
					$values['name'] = $values['names_en'].$values['name_en'];
				}
			}
			unset($values);
		}
	}
}
unset($value);
$this -> success($list);