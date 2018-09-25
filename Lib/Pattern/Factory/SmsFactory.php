<?php
/**
 * 短信工厂
 * @author wangdb
 */
include '../../Vendor/Pattern/Factory/ISms.php';
include '../../Vendor/Pattern/Factory/Lib/Aliyun.php';
include '../../Vendor/Pattern/Factory/Lib/Txyun.php';

class SmsFactory{
    // 生成短信对象
    public static function createSms($func){
        return new $func();
    }
}