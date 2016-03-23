<?php
	$where = array(
		'key' => 'webOption'
	);
	$res = M('kv')->where($where)->getFIeld('value');
	if($res){
		$bgimg = json_decode($res,true);
		$this->success(getDomainThumb($bgimg['login_img'],750,1334));
	}else{
		$this -> error(10201);
	}
    
