<?php
/**
 * 工厂模式之短信入口
 * @author wangdb
 */
include '../../Ext/Pattern/Factory/SmsFactory.php';

class XhSms{
    CONST   ALIYUN     = 'Aliyun';  // 阿里云短信
    CONST   TXYUN      = 'Txyun';  // 腾讯云短信
    private static $_instance;  // 单例
    
    /**
     * 单例模式
     * @return XhSms
     */
    public static function gi(){
        if (!self::$_instance instanceof static) {
            self::$_instance = new static();
        }
        return self::$_instance;
    }
    
    /**
     * 单条短信发送
     */
    public static function sendSms($params, $plat = self::ALIYUN){
        if(!in_array($plat,array(self::ALIYUN, self::TXYUN))){
            return '参数错误';
        }
        echo '单条短信发送【调用多条短信】<br>';
        self::sendMultiSms($params, $plat);  // 单条短信调用多条短信
        
    }
    
    /**
     * 多条短信发送
     */
    public static function sendMultiSms($params, $plat = self::ALIYUN){
        if(!in_array($plat,array(self::ALIYUN, self::TXYUN))){
            return '参数错误';
        }
        echo '多条短信发送<br>';
        $YunSms = SmsFactory::createSms( $plat );
        $YunSms->sendSms($params);
    }
}
