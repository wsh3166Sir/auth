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
     * success 执行成功返回json格式
     * @param $message 提示字符串
     * @param $url 跳转地址
     * @author 刘中胜(996674366@qq.com)
     * @time 2015-15-05
     **/
    protected function success($message, $url = '')
    {
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
     * @author 刘中胜
     * @time 2015-15-05
     **/
    protected function error($message='')
    {
        $array = array(
            'statusCode' => 300,
            'message'    => $message,
        );
        die(json_encode($array));
    }



    /**
     * login 登录页面
     * @author 刘中胜
     * @time 2015-04-29
     **/
    public function login()
    {
        if(session(C('UID'))){
            $this->redirect(C('DEFAULTS_MODULE').'Index/index');
        }else{
            $this->display();
        }
    }

    /**
     * islogin 检测登录
     * @author 刘中胜
     * @time 2015-04-29
     **/
    public function islogin()
    {
        $model = D('Admin');
        $data = $model->login();
        if($data){
            $str = self::_rules();
            $where = array(
                'id' => array('in',$str),
                'level' => 0,
                'status' => 1
            );
            $url = M('auth_cate')->where($where)->getField('module');
            $this->success('登录成功', U($url.'/Index/index'));
        }else{
            $this->error($model->getError());
        }
    }

    /**
     * code 检测验证码
     * @author 刘中胜
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
        session(C('uid'), null);
        $this->redirect(C('DEFAULTS_MODULE').'/Public/login');
    }

    /**
     * resetpwd 重置密码
     * @author 刘中胜
     * @time 2015-06-05
     **/
    public function resetpwd()
    {
        $where = array(
            'id'     => session(C('UID')),
            'status' => 1
        );
        $uid = M('admin')->where($where)->getField('id');
        $this->assign('uid', $uid);
        $this->display();
    }

    /**
     * updatepwd 修改密码操作
     * @author 刘中胜
     * @time 2015-06-05
     **/
    public function updatepwd()
    {
        $model = M();
        $model->startTrans();
        $char = randNum();
        $id = I('post.id',0,'intval');
        if(empty($id)){
             $this->error('参数错误');
        }
        $password = trim(I('post.password'));
        if($password == ''){
             $this->error('原始密码不能为空');
        }
        $new_pwd = trim(I('post.new_pwd'));
        if($new_pwd == ''){
            $this->error('新密码不能为空');
        }
        $rep_new_pwd = trim(I('post.rep_new_pwd'));
        if($rep_new_pwd == ''){
            $this->error('确认密码不能为空');
        }
        if($new_pwd != $rep_new_pwd){
            $this->error('两次密码不一致');
        }

        $where = array(
            'id' => $id,
        );
        $chars = M('char')->where($where)->getField('chars');
        $where = array(
            'password' => md5Encrypt($password, $chars),
            'status'   => 1
        );
        $user = M('admin')->where($where)->getField('id');
        if(!$user){
            $this->error('原始密码错误');
        }
        $pwd = md5Encrypt($new_pwd, $char);
        $data = array(
            'up_time'  => time(),
            'up_ip'    => get_client_ip(),
            'password' => $pwd,
        );
        $res = M('admin')->where($where)->save($data);
        if($res){
            $data = array(
                'chars' => $char,
                'id'    => $id
            );
            $res = M('char')->save($data);
            if($res === false){
                $model->rollback();
                $this->error('修改失败');
            }else{
                $model->commit();
                session(C('UID'), NULL);
                $this->success('修改成功', U('Public/login'));
            }
        }else{
            $model->rollback();
            $this->error('修改失败');
        }
    }
    /**
     * 分组权限查询
     * @author 刘中胜
     * @return array $str 返回查询到的权限
     **/
    protected function _rules()
    {
        $str = S('group_rules'.UID);
        if($str == false){
            $where = array(
                'uid' => UID
            );
            $group = M('group_access')->where($where)->getField('group_id', true);
            $where = array(
              'id'     => array('in', $group),
              'status' => 1
            );
            $list = M('group')->where($where)->getField('rules', true);
            $str = implode(',', $list);
            $strArr = explode(',', $str);
            $str = array_unique($strArr);
            S('group_rules'.UID,$str);
        }
        return $str;

    }
    /**
     * flashupload 上传方法
     * @author 刘中胜
     * @time 2015-3-17
     **/
    public function flashupload(){
        $upload           = new \Think\Upload();
        $upload->maxSize  = 31457280000;
        $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
        $rootPath         = $upload->rootPath = './Upload/';
        $upload->autoSub  = false;
        $upload->savePath = date('Y/md/');
        $info             = $upload->upload();
        if(!$info){
            header("HTTP/1.1 500 Internal Server Error");
            echo $upload->getError();
            exit(0);
        }
		//接受上传类型
		$upload_type = I('get.type');
		//如果上传类型不是文件则执行如下代码
		if($upload_type != 'file'){
			$imgSrc    = $rootPath.$info['Filedata']['savepath'].$info['Filedata']['savename'];
			$widthArr  = explode(',', I('get.width', '','trim'));
			$heightArr = explode(',', I('get.height', '','trim'));
			$resArr    = array();

			if(!empty($widthArr)){
				$image = new \Think\Image();
				//图片裁剪
				foreach($widthArr as $key=>$w){
					$w = trim($w);
					$h = trim($heightArr[$key]);
					$image->open($imgSrc);
					$thumbName =  $rootPath.$info['Filedata']['savepath']."thumb/{$w}x{$h}/".$info['Filedata']['savename'];
					if(!is_dir(dirname($thumbName))){
						mkdir(dirname($thumbName), 0755, true);
					}
					$image -> thumb($w, $h, 3)
						-> save($thumbName,$info['ext'],100);
						$watermark = I('get.watermark',0,'intval');
						//检测是否打水印如果等于1则代表需要打水印，
						if($watermark == 1){
							$waterMarkImg = C('WATER_MARK_IMG');
							$warerMarkPos = C('WATER_MARK_POS');
							if(!is_array($warerMarkPos)){
								$warerMarkPos = array(9);
							}
							foreach ($warerMarkPos as $value) {
								$image->open($thumbName)->water($waterMarkImg, $value)->save($thumbName);
							}
						}
					if(!isset($resArr['thumb'])){
						$resArr['thumb'] = ltrim($thumbName, '.');
					}
				}
			}
			if(!isset($resArr['thumb'])){
				$resArr = ltrim($imgSrc, '.');
			}
		}
        $resArr['img'] = ltrim($imgSrc, '.');
        die(json_encode($resArr));
    }

    /**
     * editUpload 编辑器上传图片
     * @author 刘中胜
     * @time 2015-04-29
     **/
    public function editUpload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $rootPath = $upload->rootPath  =     './Upload/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $upload->autoSub  = true;
        $upload->subName  = array('date','Y/m/d');
        // 上传文件
        $info   =   $upload->upload();
        $arr = array();
        if(!$info){

            $arr['state']           = 'ERROR';
        }else{
            $infos = $info['upfile'];
            $savePath = ltrim($infos['savepath'],'.');
            $filePathName = '/Upload/'.$savePath.$infos['savename'];
            $arr['originalName']    = $infos['name'];
            $arr['name']            = $infos['savename'];
            $arr['url']             = $filePathName;
            $arr['size']            = $infos['size'];
            $arr['type']            = $infos['ext'];
            $arr['state']           = 'SUCCESS';
        }
        die(json_encode($arr));
    }

}
