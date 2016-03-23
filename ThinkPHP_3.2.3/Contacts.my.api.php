<?php
$this->checklogin();
$Language = I('post.Language',0,'intval');
switch ($Language) {
	case 0:
		$field='name,names';
		break;
	case 1:
		$field='name_en,names_en';
		break;
	default:
		$this -> error(10205);
		break;
}
require('./Application/Common/Lib/Hxcall.class.php');
$rs = new \Hxcall();
$res = $rs->hx_contacts_user('USPndEnl');
$json = json_decode($res,true);
$where = array(
	'member' => array('in',$json['data']),
	'status' => 1
);
$list = M('user')->where($where)->field('id,thnum,'.$field)->select();
$dataArr = array();
foreach ($list as $key => $value) {
	if($Language == 0){
		$pinyin = Pinyin($value['name'],1);
		$pinyin = ucwords(substr($pinyin,0,1));
		if(in_array($pinyin, $dataArr)){
			array_unshift($dataArr, $value['name']);
		}else{
			$dataArr[$pinyin][] = $value;
			foreach($dataArr[$pinyin] as $k => &$v){
				$v['name'] = $v['name'].$v['names'];
			}
			unset($v);
		}
	}else{
		$pinyin = ucwords(substr($value['name_en'],0,1));
		if(in_array($pinyin, $dataArr)){
			array_unshift($dataArr, $value['name_en']);
		}else{
			$dataArr[$pinyin][] = $value;
			foreach($dataArr[$pinyin] as $k => &$v){
				$v['name'] = $v['names_en'].' '.$v['name_en'];
			}
			unset($v);
		}
	}
}
ksort($dataArr);
$this -> success($dataArr);