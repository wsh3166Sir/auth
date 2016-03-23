<?php
$id       = I('post.id',0,'intval');
$uid      = I('post.uid',0,'intval');
if(empty($id)){
	$this -> error(10213);
}
$Language = I('post.Language',0,'intval');
switch ($Language) {
	case 0:
		$field = 'name,names,positions,keywords,desc,area';
		$valuename = 'name';
		$fields = 'a.name,a.names,b.name as bname';
		$uaerinfo = 'a.title,b.title as btitle,a.address';
		$tuijian = 'title,address';
		break;
	case 1:
		$field = 'name_en,names_en,positions_en,keywords_en,desc_en,area_en';
		$valuename = 'name_en';
		$fields = 'a.name_en,a.names_en,b.name_en as bname_en';
		$uaerinfo = 'a.title_en,b.title_en as btitle_en,a.address_en';
		$tuijian = 'title_en,address_en';
		break;
	default:
		$this -> error(10205);
		break;
}
$where = array(
	'a.status' => 1,
	'a.id'     => $id
 );
$list = M()
	-> table('__SCHEDULE__ a')
	-> join('LEFT JOIN __ARTICLE_CATE__ b ON a.cid=b.id')
	-> field('a.id,a.start_time,a.end_time,a.tid,'.$uaerinfo)
	-> where($where)
	-> select();
foreach ($list as $key => &$value) {
	$where = array(
		'sid' => $value['id'],
	);
	$user_id = M('schedule_user_index')->where($where)->getField('uid',true);
	if($user_id){
		$where = array(
			'a.id' 	=> array('in',$user_id),
			'a.status'=> 1
		);
		$value['user'] = M()
			-> table('__USER__ a')
			-> join('LEFT JOIN __EXHIBITORS__ b ON a.units=b.id')
			-> field('a.id,'.$fields)
			-> where($where)
			-> select();
		foreach ($value['user'] as $k => &$v) {
				if($Language == 0){
					$v['name'] = $v['name'].$v['names'];
				}else{
					$v['name'] = $v['names_en'].' '.$v['name_en'];
				}
			}
			unset($v);
		$where = array(
			'id'  => array('in',$value['tid']),
			'status' => 1
		);
		$value['tuijian'] = M('schedule')->where($where)->field('id,start_time,end_time,'.$tuijian)->select();
		foreach ($value['tuijian'] as $k => &$v) {
			$where = array(
				'sid' => $v['id'],
			);
			$user_id = M('schedule_user_index')->where($where)->getField('uid',true);
			$where = array(
				'a.id' 	=> array('in',$user_id),
				'a.status'=> 1
			);
			$v['user'] = M()
				-> table('__USER__ a')
				-> join('LEFT JOIN __EXHIBITORS__ b ON a.units=b.id')
				-> field('a.id,'.$fields)
				-> where($where)
				-> select();
			foreach ($v['user'] as $k => &$vs) {
				if($Language == 0){
					$vs['name'] = $vs['name'].$vs['names'];
				}else{
					$vs['name'] = $vs['names_en'].' '.$vs['name_en'];
				}
			}
			unset($v);
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
}
unset($value);
$this -> success($list);