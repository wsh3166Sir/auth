<?php
namespace Admin\Controller;
class IndexController extends PrivateController {
    public function index(){
        $module = MODULE_NAME;
        $modules = I('get.module','');
        if(!empty($modules)){
            delTemp();
        }
        $this -> redirect(MODULE_NAME.'/'.CONTROLLER_NAME.'/info');

        // dump($createTime = M()->query("show columns from {$v}"));
	}

    // public function info()
    // {
        
    //     $module     = 'Admin';//模块名称
    //     $model      = 'User';//模型名称
    //     $auth_verification = 1; //是否开启自动验证 1开启 0 不开启
    //     $is_inherit = 0; //为0 时候不继承Public
    //     $filename   ='./Application/Admin/Model/ceshi3'."Model.class.php";
    //     $str        = "<?php\r\n";
    //     $str       .= 'namespace '.$module."\Model;\r\n";
    //     if($is_inherit == 0){
    //         $str   .= "use Think\Model;\r\n";
    //         $str   .= 'class '.$model."Model extends Model\r\n{\r\n";
    //     }else{
    //         $str   .= 'class '.$model."Model extends PublicModel\r\n{\r\n";
    //     }
    //     $str   .= "\r\n";
    //     if($auth_verification == 1){
    //         $str   .= "    /**\r\n";
    //         $str   .= "     * $_validate 自动验证\r\n";
    //         $str   .= "     * @author 刘中胜\r\n";
    //         $str   .= "     * @time 2015-04-14\r\n";
    //         $str   .= '    **/'."\r\n";
    //         $str   .= "    protected $_validate = array(\r\n";
    //         $str   .= "        array('username', 'require', '帐号必须填写'),\r\n";
    //         $str   .= "    );\r\n";
    //     }
    //     $str   .= '}';
    //     if (!$head=fopen($filename, "w+")) {//以读写的方式打开文件，将文件指针指向文件头并将文件大小截为零，如果文件不存在就自动创建
    //         die("尝试打开文件[".$filename."]失败!请检查是否拥有足够的权限!创建过程终止!");
    //     }
    //     if (fwrite($head,$str)==false) {//执行写入文件
    //         fclose($head);
    //         die("写入内容失败!请检查是否拥有足够的权限!写入过程终止!");
    //     }
    //     echo "成功创建UTF-8格式文件[".$filename."]，并向该文件中写入了内容：".$str;
    //     fclose($head);
    // }

    public function aa(){

        $this -> display();
    }
    public function b()
    {
        if(SendMail($_POST['mail'],$_POST['title'],$_POST['content'])) {
            $this->success('发送成功！');
        } else {
            $this->error('发送失败');
        }
    }
}
