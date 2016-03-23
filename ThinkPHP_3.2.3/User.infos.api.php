<?php
$this->checklogin();
$uid = I("post.uid", 0, 'intval');
$Language = I('post.Language',0,'intval');
switch ($Language) {
	case 0:
		$field='a.name,a.names,b.name as bname,a.positions,a.keywords,a.area,c.name as c.country';
		break;
	case 1:
		$field='a.name_en,a.names_en,b.name_en as bname_en,a.positions_en,a.keywords_en,a.area_en,c.name_en as c.country_en';
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
	-> join('LEFT JOIN __CITY__ c ON a.country=c.id')
	-> field('a.id,a.thnum,a.phone,a.twitter,a.facebook,a.linkedin,a.weibo,a.WeChat,a.web,a.emails,a.desc,'.$field)
	-> where($where)
	-> find();
$this -> success($info);