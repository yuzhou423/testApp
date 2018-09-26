<?php
use Controllers\Controller;
class IndexController extends Controller {
    /**
     * 测试方法
     */
    public function indexAction(){
        var_dump(111112222);
        $params = [];
        $res = XhSms::gi()->sendSms($params, XhSms::ALIYUN);
        
        var_dump($res);
    }
}