<?php
$this->checklogin();
$uid = I("post.uid", 0, 'intval');
$Language = I('post.Language',0,'intval');
switch ($Language) {
	case 0:
		$field = 'a.name,a.names,b.name as bname';
		break;
	case 1:
		$field = 'a.name_en,a.names_en,b.name_en as bname_en';
		break;
	default:
		$this -> error(10205);
		break;
}
$where = array(
	'a.status' => 1,
	'a.id'     => $uid
);
$info = M()
	-> table('__USER__ a')
	-> join('LEFT JOIN __EXHIBITORS__ b ON a.units=b.id')
	-> field('a.id,a.thnum,'.$field)
	-> where($where)
	-> find();
if($Language == 0){
	$info['name'] = $info['name'].$info['names'];
}else{
	$info['name'] = $info['names_en'].$info['name_en'];
}
$this -> success($info);