<?php

namespace Core;


use Exception;

class Router
{
    /**
     * Routes (urls) - e.g. -> users/5/show
     * @var array
     */
    protected $routes = [];

    protected $params = [];

    protected $convertTypes = [
        'd' => 'int',
        's' => 'string'
    ];

    protected $controllerNamespace = "App\Controllers\\";


    /**
     * Add route to routes e.g. -> users/{id:int}/show
     * @param string $route
     * @param array $params
     */
    public function add(string $route, array $params = [])
    {
        // Convert to route to a regular expression: escape forward slashes
        $route = preg_replace("/\//", "\\/", $route);

        // Convert variables e.g. {controller}
        $route = preg_replace("/\{([a-z]+)\}/", '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        //?P - grouping
        $route = preg_replace("/\{([a-z]+):([^\}]+)\}/", '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case-insensitive flag
        $route = "/^{$route}$/i";

        $this->routes[$route] = $params;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Match the rout to the routes in the routing table, setting the $params
     * property if a route is found.
     * @param $url
     * @return bool
     */
    public function match($url): bool
    {
//        dd($url);
        foreach ($this->routes as $route => $params) {

            /**
             * e.g.
             * $this->routes
             * array:1 [▼
             * "/^posts\/(?P<id>\d+)\/show$/i" => array:2 [▼
             *          "controller" => "ArticlesController"
             *          "action" => "show"
             *          ]
             * ]
             */
//            preg_match('/^posts\/(?P<id>\d)\/show$/i', $url);
//            dd($this->routes, '/^posts\/(?P<id>\d)\/show$/i', $url, preg_match('/^posts\/(?P<id>\d+)\/show$/i', $url));
            if (preg_match($route, $url, $matches)) {
//            dd($matches);
                /**
                 * e.g.
                 * $matches
                 * array:3 [
                 * 0 => "posts/5/show"
                 * "id" => "5"
                 * 1 => "5"
                 * ]
                 */

                preg_match_all("/\(\?P<[\w]+>\\\\([\w\+]+)\)/", $route, $types);

                /**
                 * e.g.
                 * $types
                 * array:2 [▼
                 *  0 => array:1 [▼
                 *      0 => "(?P<id>\d+)"
                 *      ]
                 *  1 => array:1 [▼
                 *      0 => "d+"
                 *      ]
                 * ]
                 */

                $step = 0;
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {

                        $type = trim($types[1][$step], "+");

                        settype($match, $this->convertTypes[$type]);

                        $params[$key] = $match;

                        $step++;
                    }
                }

                /**
                 * e.g.
                 * $params
                 * array:3 [▼
                 * "controller" => "ArticlesController"
                 * "action" => "show"
                 * "id" => 5
                 * ]
                 */

                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function dispatch(string $url = "")
    {

        $url = $this->removeQueryStringVariables($url);
//        dd($this->match($url));
        if ($this->match($url)) {
            $controller = $this->params["controller"];
            unset($this->params["controller"]);
            $controller = $this->getNamespace() . $controller;
            $this->convertToStudlyCaps($controller);

            if (class_exists($controller)) {

                $controllerObject = new $controller($this->params);

//                dd($controllerObject, $this->params);

                $action = $this->params["action"];
                unset($this->params["action"]);
                $action = $this->convertToCamelCase($action);
//                dd($this->params);
                if (preg_match("/action$/i", $action) == 0) {
                    call_user_func_array([$controllerObject, $action], $this->params);
                } else {
                    $msg = "Method {$action} in controller {$controller} can not be directly called" .
                        " - remove the Action suffix to call this method";
                    throw new Exception($msg);
                }
            } else {
                throw new Exception("controller class {$controller} not found");
            }
        } else {
            throw new Exception("No route matched", 404);
        }

    }

    /**
     * e.g -> users/index => Users/Index
     * @param string $string
     * @return string|string[]
     */
    protected function convertToStudlyCaps(string $string)
    {
        return str_replace(" ", "", ucwords(str_replace("-", " ", $string)));
    }

    /**
     * @param string $string
     * @return string
     */
    protected function convertToCamelCase(string $string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    protected function removeQueryStringVariables(string $url): string
    {
        if ($url != "") {
            $parts = explode("&", $url, 2);

            if (strpos($parts[0], "=") === false) {
                $url = $parts[0];
            } else {
                $url = "";
            }
        }

        return $url;
    }

    /**
     * @return string
     */
    protected function getNamespace(): string
    {
        $namespace = $this->controllerNamespace;

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params["namespace"] . "\\";
        }

        return $namespace;
    }


}