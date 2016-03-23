<?php
$this->checklogin();
$id = I("post.id", 0, 'intval');
if(empty($id)){
	$this -> error(10213);
}
$Language = I('post.Language',0,'intval');
switch ($Language) {
	case 0:
		$field = 'name,names,positions,keywords,desc,area';
		$valuename = 'name';
		break;
	case 1:
		$field = 'name_en,names_en,positions_en,keywords_en,desc_en,area_en';
		$valuename = 'name_en';
		break;
	default:
		$this -> error(10205);
		break;
}
$where = array(
	'status' => 1,
	'id'     => $id
);
$info = M('user')->where($where)->field('id,thnum,units,twitter,facebook,linkedin,weibo,web,WeChat,emails,'.$field)->find();
if($Language == 0){
	$info['keywords'] = explode(',', $info['keywords']);
	$info['name'] = $info['name'].$info['names'];
}else{
	$info['keywords'] = explode(',', $info['keywords_en']);
	$info['name'] = $info['names_en'].' '.$info['name_en'];
}
$where = array(
	'id' => $info['units'],
	'status' => 1
);
$info['units'] = M('exhibitors')->where($where)->getField($valuename);
$this -> success($info);