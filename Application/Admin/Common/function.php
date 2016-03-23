<?php
/**
 * randNum 生成随机数
 * @author 刘中胜
 * @time 2015-08-14
 **/
function randNum(){
    return mt_rand(1000,99999999);
}

/**
 * md5Encrypt 加密函数
 * @param string $str 要加密的字符串
 * @return string $chars 加密后的字符串
 * @author 刘中胜
 * @time 2015-04-13
 **/
function md5Encrypt($str='',$rand=''){
    $hash = $str.$rand;
    $chars =  MD5(hash('sha256', $hash));
    return $chars;
}

/**
 * code 验证码函数
 * @param int $length 验证码长度默认为4
 * @param int $width 验证码图片宽度默认为100
 * @param int $height 验证码图片高度 默认为30
 * @param string $code 验证码session里面的key 默认code
 * @author 刘中胜
 * @time 2014-12-5
 **/
function code($size='24',$length='4',$width='100',$height='40',$verifyName = 'code'){
    $w = $width-1;
    $h = $height-1;
    $image = imagecreate($width,$height);
    $imagecolor = imagecolorallocate($image,255,255,255);
    $bordercolor = imagecolorallocate($image,0,0,0);
    $rectangle  = imagerectangle($image,0,0,$w,$h,$bordercolor);
    for($i=0;$i<$length;$i++){
        $fontsize = $size;
        $fontcolor = imagecolorallocate($image,rand(1,120),rand(1,120),rand(1,120));
        $data = 'zxcvbnmasdfghjkqwertyup23456789';
        $str .= $fontcontent = substr($data,rand(0,strlen($data)-1),1);
        $x = ($i*$width/$length) + rand(3,10);
        $y = rand(2,12);
        imagestring($image,$fontsize,$x,$y,$fontcontent,$fontcolor);
    }

    session($verifyName,md5($str));
    for($i=0;$i<200;$i++){
        $xelcolor = imagecolorallocate($image,rand(80,220),rand(80,220),rand(80,220));
        imagesetpixel($image,rand(1,$w),rand(1,$h),$xelcolor);
    }
    for($i=0;$i<4;$i++){
        $imageline = imagecolorallocate($image,rand(80,220),rand(80,220),rand(80,220));
        imageline($image,rand(1,$w),rand(1,$h),rand(1,$w),rand(1,$h),$imageline);
    }
    ob_clean();
    header('content-type:image/png');
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
//     M() -> execute("DROP TABLE IF EXISTS `$tablename` ");

// ;

// '
//     M()-> execute("CREATE TABLE `$tablename`({$mysql})" );
}

