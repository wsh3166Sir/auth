<?php
$this->checklogin();
$type = I('post.type',0,'intval');
$Language = I('post.Language',0,'intval');
$pagenum    = I('post.pagenum',1,'intval');
$page    = I('post.page',10,'intval');
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
$where = array(
	'status' => 1
);
switch ($type) {
	case 1:
		$where['type'] = '2';
		break;
	case 2:
		$where['type'] = '1';
		break;
	case 3:
		$where['type'] = '3';
		break;
	default:
		$this -> error(10209);
		break;
}
$list = M('user')->where($where)->field('id,member,thnum,'.$field)->limit(($page-1)*$pagenum, $pagenum)->select();
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