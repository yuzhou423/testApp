<?php
/**
 * 短信工厂
 * @author wangdb
 */
include '../../Ext/Pattern/Factory/ISms.php';
include '../../Ext/Pattern/Factory/Lib/Aliyun.php';
include '../../Ext/Pattern/Factory/Lib/Txyun.php';

class SmsFactory{
    // 生成短信对象
    public static function createSms($func){
        return new $func();
    }
}