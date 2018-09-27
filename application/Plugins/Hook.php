<?php
/**
 * @name SamplePlugin
 * @desc Yaf定义了如下的6个Hook,插件之间的执行顺序是先进先Call
 * @see http://www.php.net/manual/en/class.yaf-plugin-abstract.php
 * @author 504
 */
class HookPlugin extends \Yaf\Plugin_Abstract {

	public function routerStartup(\Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response) {
    }

	public function routerShutdown(\Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response) {
        $uri = $request->getRequestUri();
        if ("/" === $uri) {
            $config = \Yaf\Registry::get("config")->application->routes['index']['route'];

            if(!$config){
                echo 404;exit;
            }

            $request->module = $config->module;
            $request->controller = $config->controller;
            $request->action = $config->action;
            $domain = strtolower(explode('.', $_SERVER['HTTP_HOST'])[0]);
            $domainConf = \Yaf\Registry::get("config")->application->domain;
            if (isset($domainConf->$domain) && !empty($domainConf->$domain)) {
                $request->module = $domainConf->$domain;
            }
            $path = CONTROLLER_PATH . '/' . $config->module . '/' . $config->controller . 'Controller.php';
        } else {
            //获取url路由
            $tmp = array_values(array_filter(explode('/', $uri)));
            $request->controller = str_replace('_', ' ', $request->controller);
            $request->controller = str_replace(' ', '', ucwords($request->controller));
            $request->action = str_replace('_', ' ', $request->action);
            $request->action = str_replace(' ', '', ucwords($request->action));
            if (count($tmp) == 3) {
                if (isset($tmp[0])) {
                    $request->module = $tmp[0];
                }
                if (isset($tmp[1]) && strtolower($tmp[1]) == strtolower($request->controller)) {
                    $request->controller = $tmp[1];
                }
                if (isset($tmp[2]) && strtolower($tmp[2]) == strtolower($request->action)) {
                    $request->action = $tmp[2];
                }
            } else {
                if (isset($tmp[0]) && strtolower($tmp[0]) == strtolower($request->controller)) {
                    $request->controller = $tmp[0];
                }
                if (isset($tmp[1]) && strtolower($tmp[1]) == strtolower($request->action)) {
                    $request->action = $tmp[1];
                }
            }

            //二级域名转发
            $domain = strtolower(explode('.', $_SERVER['HTTP_HOST'])[0]);
            $domainConf = \Yaf\Registry::get("config")->application->domain;

            if (isset($domainConf->$domain) && !empty($domainConf->$domain)) {
                $request->module = $domainConf->$domain;
            }
            $path = CONTROLLER_PATH . '/' . ucfirst($request->module) . '/' . ucfirst($request->controller) . 'Controller.php';
            unset($domain, $domainConf, $tmp);
        }

        define('MODULE_NAME', ucfirst($request->module));
        define('CONTROLLER_NAME', ucfirst($request->controller));
        define('ACTION_NAME', $request->action);
        if (file_exists($path)) {
            require_once $path;
        } else {
            header('HTTP/1.1 404 Not Found');
        }
	}

	public function dispatchLoopStartup(\Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response) {
	}

	public function preDispatch(\Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response) {
	}

	public function postDispatch(\Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response) {
	}

	public function dispatchLoopShutdown(\Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response) {
	}
}
