<?php
/**
 * 短信工厂
 * @author wangdb
 */
namespace Ext\Pattern\Factory;
include 'ISms.php';
include 'Lib/Aliyun.php';
include 'Lib/Txyun.php';

class SmsFactory{
    // 生成短信对象
    public static function createSms($func){
        return new $func();
    }
}