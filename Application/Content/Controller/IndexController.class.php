<?php
namespace Content\Controller;
use Admin\Controller\PrivateController;
class IndexController extends PrivateController {
    public function index(){
        $module = MODULE_NAME;
        $modules = I('get.module','');
        if(!empty($modules)){
            delTemp();
        }
        $this -> redirect(MODULE_NAME.'/'.CONTROLLER_NAME.'/info');
	}

    public function info()
    {
        // $auth_add = '';
        // $table  = array();
        // $tableKey = '';
        // $field_type = array('int','tinyint','smallint','mediumint','bigint','float','double','decimal');
        // foreach ($array as $key => $value) {
        //     $str = '`'.$value[0].'`'.' '.$value[1].'('.$value[2].')';
        //     if(in_array($value[6], $field_type)){
        //         if($value[6] == 0){
        //             $str .= ' unsigned ';
        //         }
        //     }
        //     if($value[5] == 1){
        //         $str .= ' NOT NULL ';
        //     }
        //     if($value[7] == 1){
        //         if($auth_add == 'AUTO_INCREMENT'){
        //             echo '1';
        //             return false;
        //         }else{
        //             $str .= 'AUTO_INCREMENT';
        //             $auth_add = 'AUTO_INCREMENT';
        //             $tableKey = $value[0];
        //         }
        //     }
        //     if($value[7] != 1){
        //         if($value[3] != ''){
        //             $str .= ' DEFAULT'."'{$value[3]}'";
        //         }else{
        //             $str .= ' DEFAULT'." ''";
        //         }
        //     }
        //     if ($value[8]!='') {
        //        $str .= " COMMENT '{$value[8]}'";
        //     }
        //     $table[$key] = $str;
        // }
        // $tableKeyStr = "PRIMARY KEY (`{$tableKey}`)";
        // array_push($table, $tableKeyStr);
        // $tab=implode(',', $table);
        // $sql = "CREATE TABLE `{$tableName}` ({$tab}) ENGINE={$engine} AUTO_INCREMENT={$auth_adds} DEFAULT CHARSET={$charset} COMMENT='{$comment}'";
        $this -> display();
    }
}
