<?php
// +----------------------------------------------------------------------
// | 基于Thinkphp3.2.3开发的一款权限管理系统
// +----------------------------------------------------------------------
// | Copyright (c) www.php63.cc All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 普罗米修斯 <996674366@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Think\Controller;

class PublicController extends Controller
{
	/**
	 * ship 没有条件时跳转地址
	 * @author 普罗米修斯(996674366@qq.com)
	 **/
	public function skip(){
		session(C('ADMIN_UID'), null);
		$this->redirect(C('DEFAULTS_MODULE') . '/Public/login');
	}
    /**
     * success 执行成功返回json格式
     * @param $message 提示字符串
     * @param $url 跳转地址
     * @author 普罗米修斯(996674366@qq.com)
     * @time 2015-15-05
     **/
    protected function success1($message, $url = '')
    {


        E("11") ;
        $array = array(
            'statusCode' => 200,
            'message'    => $message,
            'url'        => $url
        );
        die(json_encode($array));
    }

    /**
     * error 执行成功返回json格式
     * @param string $message 提示字符串
     * @param string $url 跳转地址
     * @author 普罗米修斯
     * @time 2015-15-05
     **/
    protected function error($message = '')
    {
        $array = array(
            'statusCode' => 300,
            'message'    => $message,
        );
        die(json_encode($array));
    }


    /**
     * login 登录页面
     * @author 普罗米修斯
     * @time 2015-04-29
     **/
    public function login()
    {
        if(session(C('ADMIN_UID'))) $this->redirect(C('DEFAULTS_MODULE').'/Index/index');
        $this->display();
    }

    /**
     * islogin 检测登录
     * @author 普罗米修斯
     * @time 2015-04-29
     **/
    public function islogin()
    {
        $model = D('Admin');
        $data = $model->login();
        if ($data) {
            //登陆后获取所属分组的id
            $str = self::_rules();
            //查询默认跳转地
            $where = array(
                'id'     => array('in', $str),
                'level'  => 0,
                'status' => 1
            );
			//调用getOneField方法传参格式getOneField('字段','条件（数组）','指定条数或者true如果只查询一条就为空','排序方式')
            
            $url = D('AuthCate')->where($where)->order('sort DESC')->getField('module');
            $this->success('登录成功了', U($url . '/Index/index'),0);
        }
        $this->error($model->getError());
    }

    /**
     * code 检测验证码
     * @author 普罗米修斯
     * @time 2015-3-23
     **/
    public function code()
    {
        code();
    }
    /**
     * logout 退出登录
     * @author 刘中胜
     * @time 2015-06-05
     **/
    public function logout()
    {
        session(C('ADMIN_UID'), null);
        $this->redirect(C('DEFAULTS_MODULE') . '/Public/login');
    }
    /**
     * updatepwd 修改密码操作
     * @author 普罗米修斯
     * @time 2015-06-05
     **/
    public function updatepwd()
    {
        $model = M();
        $model->startTrans();
        $char = randNum();
		$id = session(C('ADMIN_UID'));
        $password = trim(I('post.password'));
        if ($password == '') {
            $this->error('原始密码不能为空');
        }
        $new_pwd = trim(I('post.new_pwd'));
        if ($new_pwd == '') {
            $this->error('新密码不能为空');
        }
        $rep_new_pwd = trim(I('post.rep_new_pwd'));
        if ($rep_new_pwd == '') {
            $this->error('确认密码不能为空');
        }
        if ($new_pwd != $rep_new_pwd) {
            $this->error('两次密码不一致');
        }
		//定义字符串表model
		$charModel = D('Char');
        $where = array(
            'id' => $id,
        );
		//获取和用户匹配的字符串
        $chars = $charModel->getOneField('chars',$where);
		//定义用户model
		$userModel = D('Admin');
		//检测用户是否存在
        $where = array(
            'password' => md5Encrypt($password, $chars),
            'status'   => 1
        );
        $user = $userModel->getOneField('id',$where);
        if (!$user) {
            $this->error('原始密码错误');
        }
        $pwd = md5Encrypt($new_pwd, $char);
        $data = array(
            'up_time'  => time(),
            'up_ip'    => get_client_ip(),
            'password' => $pwd,
        );
        $res = M('admin')->where($where)->save($data);
        if ($res) {
            $data = array(
                'chars' => $char,
                'id'    => $id
            );
            $res = $charModel->save($data);
            if ($res === false) {
                $model->rollback();
                $this->error('修改失败');
            }
            $model->commit();
			$this -> success('修改成功',U('skip'));
        }
        $model->rollback();
        $this->error('修改失败');
    }

    /**
     * 分组权限查询
     * @author 普罗米修斯 www.php63.cc
     * @return array $str 返回查询到的权限
     **/
    protected function _rules()
    {
        $uid = session(C('ADMIN_UID'));
        if (empty($uid)) {
            $this -> skip();
        }
        //将uid定义为常量方便后期统一使用
        defined("UID") or define("UID", $uid);
        $str = S('group_rules' . $uid);
		//定义用户-用户组model
		$userGroupId = D('GroupAccess');
        if ($str == false) {
			//调用getOneField方法传参格式getOneField('字段','条件（数组）','指定条数或者true如果只查询一条就为空')
            //	public function getOneField($file, $where=array(), $type = false,$order=''){
            $where = array(
                'status' => 1
            );
			if ($uid != C('ADMINISTRATOR')) {
				//如果为普通管理员查看当前用户的数据
                $map = array(
                    'uid' => $uid
                );
				 
				$group = $userGroupId ->where($map)->getField('group_id',true);;
                if (empty($group)) {
                    $this->error('登陆失败,权限不足');
                    $this -> skip();
                }
				$where['id'] = array('in', $group);
            }
            $list = M('group')->where($where)->getField('rules', true);
            if (empty($list[0])) {
                $this->error('登陆失败,权限不足');
                $this -> skip();
            }
            $str = implode(',', $list);
            $strArr = explode(',', $str);
            $str = array_unique($strArr);
            S('group_rules' . $uid, $str);
        }
        return $str;
    }

    /**
     * flashupload 上传方法
     * @author 普罗米修斯
     * @time 2015-3-17
     **/
    public function flashupload()
    {
        $upload = new \Think\Upload();
        $upload->maxSize = 31457280000;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $rootPath = $upload->rootPath = './Upload/';
        $upload->autoSub = false;
        $upload->savePath = date('Y/md/');
        $info = $upload->upload();
        if (!$info) {
            header("HTTP/1.1 500 Internal Server Error");
            echo $upload->getError();
            exit(0);
        }
        //接受上传类型
        $upload_type = I('get.type');
        //如果上传类型不是文件则执行如下代码
        if ($upload_type != 'file') {
            $imgSrc = $rootPath . $info['Filedata']['savepath'] . $info['Filedata']['savename'];
            $widthArr = explode(',', I('get.width', '', 'trim'));
            $heightArr = explode(',', I('get.height', '', 'trim'));
            $resArr = array();

            if (!empty($widthArr)) {
                $image = new \Think\Image();
                //图片裁剪
                foreach ($widthArr as $key => $w) {
                    $w = trim($w);
                    $h = trim($heightArr[$key]);
                    $image->open($imgSrc);
                    $thumbName = $rootPath . $info['Filedata']['savepath'] . "thumb/{$w}x{$h}/" . $info['Filedata']['savename'];
                    if (!is_dir(dirname($thumbName))) {
                        mkdir(dirname($thumbName), 0755, true);
                    }
                    $image->thumb($w, $h, 3)
                        ->save($thumbName, $info['ext'], 100);
                    $watermark = I('get.watermark', 0, 'intval');
                    //检测是否打水印如果等于1则代表需要打水印，
                    if ($watermark == 1) {
                        $waterMarkImg = C('WATER_MARK_IMG');
                        $warerMarkPos = C('WATER_MARK_POS');
                        if (!is_array($warerMarkPos)) {
                            $warerMarkPos = array(9);
                        }
                        foreach ($warerMarkPos as $value) {
                            $image->open($thumbName)->water($waterMarkImg, $value)->save($thumbName);
                        }
                    }
                    if (!isset($resArr['thumb'])) {
                        $resArr['thumb'] = ltrim($thumbName, '.');
                    }
                }
            }
            if (!isset($resArr['thumb'])) {
                $resArr = ltrim($imgSrc, '.');
            }
        }
        $resArr['img'] = ltrim($imgSrc, '.');
        die(json_encode($resArr));
    }

    /**
     * editUpload 编辑器上传图片
     * @author 普罗米修斯
     * @time 2015-04-29
     **/
    public function editUpload()
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $rootPath = $upload->rootPath = './Upload/'; // 设置附件上传根目录
        $upload->savePath = ''; // 设置附件上传（子）目录
        $upload->autoSub = true;
        $upload->subName = array('date', 'Y/m/d');
        // 上传文件
        $info = $upload->upload();
        $arr = array();
        if (!$info) {
            $arr['state'] = 'ERROR';
        } else {
            $infos = $info['upfile'];
            $savePath = ltrim($infos['savepath'], '.');
            $filePathName = '/Upload/' . $savePath . $infos['savename'];
            $arr['originalName'] = $infos['name'];
            $arr['name'] = $infos['savename'];
            $arr['url'] = $filePathName;
            $arr['size'] = $infos['size'];
            $arr['type'] = $infos['ext'];
            $arr['state'] = 'SUCCESS';
        }
        die(json_encode($arr));
    }

}
