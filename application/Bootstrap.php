<?php
use library\Util\Client;
use library\Core\Http\Factory;

/**
 * @name Bootstrap
 * @author 504
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends \Yaf\Bootstrap_Abstract{

    public function _initConfig() {
		$arrConfig = \Yaf\Application::app()->getConfig();
		\Yaf\Registry::set('config', $arrConfig);
    }

    public function _initAutoload( \Yaf\Dispatcher $dispatcher) {

        \Yaf\Loader::getInstance()->import(CORES_PATH . '/common/Static.php');
        \Yaf\Loader::getInstance()->import(CORES_PATH . '/ClassLoader.php');
        \Yaf\Loader::getInstance()->import(CORES_PATH . '/common/Functions.php');
        \Yaf\Loader::getInstance()->import(COMMON_PATH . '/Static.php');
        \Yaf\Loader::getInstance()->import(COMMON_PATH . '/Functions.php');
        $autoload = new \core\ClassLoader();
        $autoload->addClassMap(array(
            'library'=>CORES_PATH.'/library',
            'Logic' => APP_PATH.'/Logic',
            'core'    => CORES_PATH,
            'Controllers'    => CONTROLLER_PATH,
            'Model' => MODEL_PATH,
        ));
//        echo APPLICATION_PATH.'/vendor/autoload.php';
        require APP_PATH . '/Vendor/autoload.php';
        spl_autoload_register(array($autoload, 'loader'));
        $dispatcher->autoload = $autoload;
    }

	public function _initPlugin(\Yaf\Dispatcher $dispatcher) {
		//注册一个插件
		$objSamplePlugin = new HookPlugin();
		$dispatcher->registerPlugin($objSamplePlugin);
	}

	public function _initRoute(\Yaf\Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
        $router = $dispatcher->getRouter();
        $router->addConfig(\Yaf\Registry::get("config")->application->routes);
	}

	public function _initView(\Yaf\Dispatcher $dispatcher){
        $dispatcher->autoRender(false);
		//在这里注册自己的view控制器，例如smarty,firekylin
	}

    public function _initErrorHandler(\Yaf\Dispatcher $dispatcher){
	    register_shutdown_function(array($this,'shutdown_function'));
	    set_error_handler(array($this,'error_handler'));
	    set_exception_handler(array($this,'exception_handler'));
	    $dispatcher->getInstance()->setErrorHandler(array($this,'error_handler'));
    }

    public function _initLog( \Yaf\Dispatcher $dispatcher ) {
        //初始化日志打印
        \library\Log::addLogNode("ip",       \library\Util\Client::getIp());
        \library\Log::addLogNode("ua",       __server_get_data('HTTP_USER_AGENT'));
        \library\Log::addLogNode("refer",    __server_get_data('HTTP_REFERER'));
        \library\Log::addLogNode("metchod",  __server_get_data('REQUEST_METHOD') .":". __server_get_data('SERVER_PROTOCOL'));
        \library\Log::addLogNode("uri",      __server_get_data('REQUEST_URI'));
        \library\Log::addLogNode("cookie",   \library\Core\Http\Factory::makeQuery($_COOKIE, ";"));
        \library\Log::addLogNode("rtime",    __server_get_data('REQUEST_TIME_FLOAT')/1000);
    }

	function error_handler($errno, $errstr, $errfile, $errline)
	{
		switch ($errno) {
			case \YAF\ERR\NOTFOUND\CONTROLLER:
			case \YAF\ERR\NOTFOUND\MODULE:
			case \YAF\ERR\NOTFOUND\ACTION:
				header("Not Found");
				break;
			default:
				$log = "Unknown error type: [$errno] $errstr<br /> in file $errfile ; in line $errline \n";
				echo $log;
				break;
		}

		return true;
	}

	/**
	 * 全局异常处理函数，会捕捉没有被 try catch 处理的异常
	 * @param  [type] $exception [description]
	 * @return [type]            [description]
	 */
	function exception_handler($e)
	{
		$error = array();
		$error['message']   =   $e->getMessage();
		$trace              =   $e->getTrace();
//		if('run'==$trace[0]['function']) {
//			$error['file']  =   $e->getPrevious()->getFile();
//			$error['line']  =   $e->getPrevious()->getLine();
//		}else{
			$error['file']  =   $e->getFile();
			$error['line']  =   $e->getLine();
//		}
		$error['trace']     =   $e->getTraceAsString();
		$log = 'Error Message : '.$error['message']."\t"." file: ".$error['file']."\t"."  line: ".$error['line'].PHP_EOL;
		echo $log;
	}

	/**
	 *
	 */
	function shutdown_function(){
		$error=error_get_last();
		if($error && in_array($error['type'],array(1,4,16,64,256,4096,E_ALL))){
			$log = 'Error Message : '.$error['message']."\t"." file: ".$error['file']."\t"."  line: ".$error['line'].PHP_EOL;
			echo $log;
		}
	}

}