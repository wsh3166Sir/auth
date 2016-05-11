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
       $this -> display();
    }
}
