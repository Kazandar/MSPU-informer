<?php
class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * returns requests string
     * @return String
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }

    }
    /**
     * Parse URI
     * Found controller Name and action Name
     * Create object and use action for process requests
     */

    public function run()
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path)
        {
            if (preg_match("~$uriPattern~", "$uri"))
            {
                $internalRoute = preg_replace("~$uriPattern~","$path","$uri");
                $segments = explode('/',$internalRoute);
                $controllerName = ucfirst(array_shift($segments)).'Controller';
                $actionName = 'action'.ucfirst(array_shift($segments));
                $params = $segments;
                $controllerFile = ROOT.'/Controllers/'.$controllerName.'.php';
                if (file_exists($controllerFile))
                    include_once($controllerFile);
            $objectController = new $controllerName;
            $result = call_user_func_array(array($objectController,$actionName),$params);
            if ($result != NULL)
                break;
            }

        }

    }
}

