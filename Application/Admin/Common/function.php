<?php

  function save_log($c, $p = '')
{
    $line1 = date('Y-m-d H:i:s') . ' ' . $c . ':' . $p;
    $path = RUNTIME_PATH . 'app_log/log'.date('Y-m-d').'.log';

     // 自动创建日志目录
     $log_dir = dirname($path);
     if (!is_dir($log_dir)) {
         mkdir($log_dir, 0755, true);
     }    
    //$path = iconv( "UTF-8", "GBK",$path);
    //$handle=fopen($path,"w");//替换
    $handle = fopen($path, "a"); //追加
    fwrite($handle, $line1 . "\r\n\r\n");
    fclose($handle);
}



    /**
     * @author 普修米洛斯 www.php63.cc
     * @param int $width 宽度
     * @param int $height 高度
     * @param int $font_size 字体大小
     * @param int $code_len 验证码长度
     * @param int $line_num 线条长度
     * @param string $font 字体名称
     * @param int $interference 雪花数量
     */
    function code($width = 100, $height = 32, $font_size = 13, $code_len = 4, $line_num = 5, $font = './Public/ttf/5.TTF', $interference = 2,$verifyName = 'code'){
        $font=realpath($font);
        $image = imagecreatetruecolor($width, $height);
        $image_color = imagecolorallocate($image,mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
        imagefilledrectangle($image,0,$height,$width,0,$image_color);
        $x = $width/$code_len;
        $codeStrs = '';
        for($i = 0; $i<$code_len;$i++){
            $str = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            $font_color = imagecolorallocate($image,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            $codeStrs .= $codeStr = utf8_encode($str[mt_rand(0,strlen($str)-1)]);

            imagettftext($image,$font_size,mt_rand(-30,30),$x*$i+mt_rand(1,3),$height / 1.4,$font_color,$font,$codeStr);
        }

        //$codeStrs="qqqq";
        session($verifyName,md5(strtolower($codeStrs)));
        
        //生成线条
        for($i = 0;$i<$line_num;$i++) {
            $line_color = imagecolorallocate($image, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imageline($image, mt_rand(0,$width),mt_rand(0,$height),mt_rand(0,$width),mt_rand(0,$height), $line_color);
        }
        for($i=0;$i<$interference;$i++){
            $color = imagecolorallocate($image, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            imagestring($image,mt_rand(1,5),mt_rand(0,$width),mt_rand(0,$height),'*',$color);
        }
        header("Content-type: image/png");
        imagepng($image);
        imagedestroy($image);
    }

/**
 * checkcode 检测验证码方法
 * @param string $code 传入的验证码
 * @param string $verifyName session里面的key值
 * @author 刘中胜
 * @time 2014-12-5
 **/
function checkcode($code,$verifyName='code'){

   
    $str =strtolower($code);
    return session($verifyName) == MD5($str);
}


/**
 * 大小写转换
 * @param string $str 要转换的字符串
 * @param int    $type转换模式 1是首字母转为大写 2是换为小写
 **/
function letterChange($str,$type=1)
{
    if($type == 1){
        return ucfirst(trim($str));
    }else{
        return strtolower(trim($str));
    }
}

/**
 * 创建model
 * @param string $module model所属模块
 * @param string $model model名字
 * @author 刘中胜
 * @time 2016-01-24
 **/
function createModel($module,$model)
{
    $auth_verification = 0; //是否开启自动验证 1开启 0 不开启
    $is_inherit = 0; //为0 时候不继承Public
    $filename   ='./Application/'.$module.'/Model/'.$model."Model.class.php";
    if(file_exists($filename)){
        return '存在';
    }
    $str        = "<?php\r\n";
    $str       .= 'namespace '.$module."\Model;\r\n";
    if($is_inherit == 0){
        $str   .= "use Think\Model;\r\n";
        $str   .= 'class '.$model."Model extends Model\r\n{\r\n";
    }else{
        $str   .= 'class '.$model."Model extends PublicModel\r\n{\r\n";
    }
    $str   .= "\r\n";
    if($auth_verification == 1){
        $str   .= "    protected $_validate = array(\r\n";
        $str   .= "        array('username', 'require', '帐号必须填写'),\r\n";
        $str   .= "    );\r\n";
    }
    $str   .= '}';
    if (!$head=fopen($filename, "w+")) {//以读写的方式打开文件，将文件指针指向文件头并将文件大小截为零，如果文件不存在就自动创建
        die("尝试打开文件[".$filename."]失败!请检查是否拥有足够的权限!创建过程终止!");
    }
    if (fwrite($head,$str)==false) {//执行写入文件
        fclose($head);
    }
    fclose($head);
}


/**
 * 创建表
 * @param string $tablename 表名
 * @author 刘中胜
 * @time 2016-01-26
 **/
function createMysqlTable($tablename='test')
{
    $arr = array(array('id','int','10','1','NOT NULL','AUTO_INCREMENT'));
    $dataArr = array();
    foreach ($arr as $key => $value) {
        
        foreach ($value as $k => $v) {
            switch ($k) {
                case 0:
                    $dataArr[] = '`'.$v.'`';
                    break;
                case 1:
                    $dataArr[] = $v.'('.$value[2].')';
                    break;
                case 3:
                    if($v == 1){
                        $dataArr[] = 'PRIMARY KEY (`'.$value[0].'`)';
                    }
                    break;
                case 5:
                    $dataArr['auth_increment'] = $v;
                    break;
                default:
                    # code...
                    break;
            }
        }
        
        //print_r(implode(' ', $value));
    }
    echo '<pre>';
    print_r(implode(' ', $dataArr));
}

