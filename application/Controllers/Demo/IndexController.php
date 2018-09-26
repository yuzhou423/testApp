<?php
use Controllers\Controller;
use Ext\Pattern\Factory\XhSms;
use Model\Test\UserModel;

class IndexController extends Controller {
    /**
     * 测试方法
     */
    public function indexAction(){
        $params = [];
        $res = XhSms::gi()->sendSms($params, XhSms::ALIYUN);
        var_dump($res);
    }
    
    /**
     * 用户方法测试
     */
    public function userAction(){
        
        var_dump(111111);
        exit;
        $idKeys = [1];
        $info = UserModel::gi()->getRealDataByIdKeys($idKeys);
        
        var_dump($info);
    }
}