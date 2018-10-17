<?php

class Router{

    private $routes;

    public function __construct(){
        $routerPath = ROOT.'/config/routes.php';
        $this->routes = require($routerPath);
    }

    /*
     * return request string
     */
    private function getURI(){
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run(){
        //получить строку запроса
        $uri = $this->getURI();

        //проверить наличие запроса в routes.php

        foreach($this->routes as $uriPattern => $path){

            //сравниваем $urlPattern и $url
            if(preg_match("~$uriPattern~", $uri)){

                //получаем внутренний путь из внешнего согласно правилу
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                //определить контлоллер, экшен и параметры
                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));

                $parameters = $segments;

                //подключить файл класса контроллера

                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

                if(file_exists($controllerFile)){
                    include_once ($controllerFile);
                }
                
                $controllerObject = new $controllerName;
                
                if(!method_exists($controllerObject,$actionName)) {
                    $er = $uri;
                    require_once (ROOT . TMPL . 'error.php');
                    return true;
                };

                $result = call_user_func_array(array($controllerObject, $actionName),$parameters);

                if($result != null){
                    break;
                }
            }

        }
    }
}