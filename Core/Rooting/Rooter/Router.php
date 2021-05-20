<?php

namespace Core\Rooting\Rooter;

use Exception;
use Core\Rooting\http_util\RequestMethodInterface;

class Router
{

    private $routes = array();
    private $namedRoutes = array();
    private $basePath = '';

    public function __construct(RouteCollection $collection)
    {
        $this->routes = $collection;

        foreach ($this->routes->all() as $route) {
            $name = $route->getName();
            if (null !== $name) {
                $this->namedRoutes[$name] = $route;
            }
        }
    }

    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '/');
    }

    public function matchCurrentRequest()
    {
        $requestMethod = (
                isset($_POST['_method']) && ($_method = strtoupper($_POST['_method'])) && in_array($_method, array(RequestMethodInterface::METHOD_PUT, RequestMethodInterface::METHOD_DELETE), true)
                ) ? $_method : $_SERVER['REQUEST_METHOD'];

        $requestUrl = $_SERVER['REQUEST_URI'];

        if (($pos = strpos($requestUrl, '?')) !== false) {
            $requestUrl = substr($requestUrl, 0, $pos);
        }

        return $this->match($requestUrl, $requestMethod);
    }

    public function match($requestUrl, $requestMethod = RequestMethodInterface::METHOD_GET)
    {
        $currentDir = dirname($_SERVER['SCRIPT_NAME']);

        foreach ($this->routes->all() as $routes) {
            if (!in_array($requestMethod, (array) $routes->getMethods(), true)) {
                continue;
            }

            if ('/' !== $currentDir) {
                $requestUrl = str_replace($currentDir, '', $requestUrl);
            }

            $route = rtrim($routes->getRegex(), '/');
            $pattern = '@^' . preg_quote($this->basePath) . $route . '/?$@i';
            if (!preg_match($pattern, $requestUrl, $matches)) {
                continue;
            }

            $params = array();

            // '/:([\w-%]+)/'
            if (preg_match_all('/:([\w-]+)/', $routes->getUrl(), $argument_keys)) {
                $argument_keys = $argument_keys[1];

                // check arguments number

                if (count($argument_keys) !== (count($matches) - 1)) {
                    continue;
                }

                foreach ($argument_keys as $key => $name) {
                    if (isset($matches[$key + 1])) {
                        $params[$name] = $matches[$key + 1];
                    }
                }
            }

            foreach ($routes->getParameters() as $parameter) {
                $params[] = $parameter;
            }

            $routes->setParameters($params);
            $routes->dispatch();

            return $routes;
        }

        return false;
    }

    public function generate($routeName, array $params = array())
    {
        if (!isset($this->namedRoutes[$routeName])) {
            throw new Exception("No route with the name $routeName has been found.");
        }
        $route = $this->namedRoutes[$routeName];
        $url = $route->getUrl();
        if ($params && preg_match_all('/:(\w+)/', $url, $param_keys)) {

            $param_keys = $param_keys[1];

            foreach ($param_keys as $key) {
                if (isset($params[$key])) {
                    $url = preg_replace('/:' . preg_quote($key, '/') . '/', $params[$key], $url, 1);
                }
            }
        }

        return $url;
    }

    public static function parseConfig(array $config)
    {
        $collection = new RouteCollection();
        foreach ($config['routes'] as $name => $route) {
            $collection->attachRoute(
                new Route(
                    $route[0], array(
                    '_controller' => str_replace('.', '::', $route[1]),
                    'methods' => $route[2],
                    'name' => $name
                    )
                )
            );
        }

        $router = new Router($collection);
        if (isset($config['base_path'])) {
            $router->setBasePath($config['base_path']);
        }

        return $router;
    }

}
