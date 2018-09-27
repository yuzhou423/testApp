<?php
use Entity\AppClient;
use library\Util\Client;
class ClientPlugin extends \Yaf\Plugin_Abstract {

    /**
     * 路由结束
     */
    public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
        $isMobile   = Client::isMobile();
        $isPhone    = Client::isPhone();
        $isIos      = Client::isIos();
        $isPad      = Client::isPad();
        $isWechat   = Client::isWechat();
        $client = new AppClient();
        // app_id
        $client->app_id = $request
        ->getCookie ( 'appid', '' );
        // t
        $client->t = $request
        ->getCookie ( 't', '' );
        // hmac_ori
        $client->hmac_ori = $request
        ->getCookie ( 'hmac', '' );
        // hmac
        $client->hmac = substr($client->hmac_ori, 0, 32 );
        // acode_ori
        $client->acode_ori = $request
        ->getCookie ( 'xhcode', '' );
        // acode
        $client->acode = substr($client->acode_ori, 0, 32 );
        // device
        $client->device = $request
        ->getCookie ( 'device', '' );

        
        $device_info = explode ( '#', $client->device );
		if (count ( $device_info ) > 9) {
			$client->system = $device_info [0];
			$client->phone_model = $device_info [1];
			$client->system_version = $device_info [2];
			$client->app_version = $device_info [3];
			$client->screen_width = $device_info [4];
			$client->screen_height = $device_info [5];
			$client->channel = $device_info [6];
			$client->network = $device_info [7];
			$client->memory = $device_info [8];
			$client->bag_name = $device_info [9];
		}

        $client->ip = ip2long( Client::getIp () );
        
        $client->isMobile   = Client::isMobile();
        $client->isPhone    = Client::isPhone();
        $client->isIos      = Client::isIos();
        $client->isPad      = Client::isPad();
        $client->isApp      = empty($client->acode) ? false : true;
        $client->isWechat   = Client::isWechat();
        $client->isFromList = (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], WEB_HOST) !== false ) ? true : false;
        
        \Yaf\Registry::set ( 'client', $client );
        return;
    }
    
    public function dispatchLoopShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
    	//记录日志
    	Core_Log::notice('');
    }
}
