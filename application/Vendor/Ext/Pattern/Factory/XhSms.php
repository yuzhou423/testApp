<?php
/**
 * 工厂模式之短信入口
 * @author wangdb
 */
namespace Ext\Pattern\Factory;

use Ext\Pattern\Factory\SmsFactory;
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
        $res = self::sendMultiSms($params, $plat);  // 单条短信调用多条短信
        return array('msg'=>'单条短信发送【调用多条短信】', "res"=>$res);
        
    }
    
    /**
     * 多条短信发送
     */
    public static function sendMultiSms($params, $plat = self::ALIYUN){
        if(!in_array($plat,array(self::ALIYUN, self::TXYUN))){
            return '参数错误';
        }
        $YunSms = SmsFactory::createSms( $plat );
        $res    = $YunSms->sendSms($params);
        return array('msg'=>'多条短信发送', "res"=>$res);
        
    }
}
