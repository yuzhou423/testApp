<?php
use Controllers\Controller;
use Ext\Pattern\Factory\XhSms;
class IndexController extends Controller {
    /**
     * 测试方法
     */
    public function indexAction(){
        $params = [];
        $res = XhSms::gi()->sendSms($params, XhSms::ALIYUN);
        var_dump($res);
    }
}