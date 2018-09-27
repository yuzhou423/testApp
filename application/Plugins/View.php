<?php
/**
 * @name Plugin_View
 * @desc 根据请求模块设置视图
 * @see http://www.php.net/manual/en/class.yaf-plugin-abstract.php
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-05-24
 */
class ViewPlugin extends \Yaf\Plugin_Abstract {

    /**
     * 路由结束以后注册View
     */
    public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
        $view_path  = 'Index' == $request->getModuleName() ? 
            APPLICATION_VIEWS_PATH : 
            APPLICATION_MODULES_PATH . "/" . $request->getModuleName() . "/Views";
        $view_class = "\\core\\View\\" . $request->getModuleName();

        $view = new $view_class( $view_path, array() );
        \Yaf\Dispatcher::getInstance()->disableView();
        \Yaf\Dispatcher::getInstance()->setView($view);

    }
    
    public function dispatchLoopShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
    	//记录日志
    	Core_Log::notice('');
    }
}
