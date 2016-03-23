<?php
//登录
    $user = I('post.eamil');
    $pwd = I('post.pwd');
    $os = I('post.os');//设备系统
    $osversion = I('post.osversion');//系统版本
    $machinecode = I('post.machinecode');//唯一码（设备机器码）
    if(trim($user)==''){
        $this->error(10101);
    }
    if(trim($pwd)==''){
        $this->error(10102);
    }
    $userModel = D('User');
    $id = $userModel->isReg($user);
    if(!$id){
        $this->error(10103);
    }
    $info = $userModel->login($user,md5($pwd),$os,$osversion,$machinecode);
    if(!$info){
        $this->error(10104);
    }
    if(!$info['status']){
        $this->error(10105);
    }
    $resArr = array(
        'uid' => $info['id'],
        'uuid' => $this->makeUuid($info['id']),
        'hid'  => $info['member'],
        'hpwd' => $info['hx_pwd']
    );
    $this->success($resArr);
