<?php
	$member = getRandStr();
	$email    = I('post.email','');
	$password = I('post.password','');
	$newpwd   = I('post.newpwd','');
	//code 为待确认功能
	$code     = I('post.code','');
    if(empty($email)){
    	$this -> error(10101);
    }
    if(empty($password)){
    	$this -> error(10102);
    }
    if(empty($newpwd)){
    	$this -> error(10106);
    }
    if($password != $newpwd){
    	$this -> error(10107);
    }
    if(empty($code)){
    	$this -> error(10108);
    }
    $data = array(
    	'email'    => $email,
    	'password' => md5($password),
    	'status'   => 1
    );
    $model = M('user');
    $result = $model -> where($data)->getFIeld('id');
    $data['name'] = $email;
    $data['name_en'] = $email;
    if($result){
    	$this -> error(10110);
    }
    $model->startTrans();
    $data['type'] = 3;
   // $data['member'] = getRandStr();
    $data['member'] = isuser($member);
    $where = array(
        'member' => $member
    );
    $data['regip'] = get_client_ip();
    $data['addtime']  = time();
    $data['hx_pwd'] = $password.mt_rand(1000,9999);
    $uid = $model ->add($data);
    if($uid){
		require('./Application/Common/Lib/Hxcall.class.php');
        $rs = new \Hxcall();
        $res = $rs->hx_register($data['member'], $data['hx_pwd'],'');
        if($res){
        	$model->commit();
        	$resArr = array(
			    'uid'  => $uid,
			    'uuid' => $this->makeUuid($uid),
			);
			$this->success($resArr);
        }else{
        	$model->rollback();
        	$this -> error(10109);
        }
    }
    $this -> error(10109);
