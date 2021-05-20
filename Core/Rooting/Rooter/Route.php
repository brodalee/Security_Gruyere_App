<?php

namespace Core\Rooting\Rooter;

/**
 * Description of Route
 *
 * @author alex
 */
class Route
{
    private $url;
    private $methods;
    private $target;
    private $name;
    private $filters = array();
    private $parameters = array();
    private $parametersByName;
    private $action;
    private $config;

    public function __construct($resource, array $config)
    {
        $this->url = $resource;
        $this->config = $config;
        $this->methods = isset($config['methods']) ? (array) $config['methods'] : array();
        $this->target = isset($config['target']) ? $config['target'] : null;
        $this->name = isset($config['name']) ? $config['name'] : null;
        $this->parameters = isset($config['parameters']) ? $config['parameters'] : array();
        $action = explode('::', $this->config['_controller']);
        $this->action = isset($action[1]) ? $action[1] : null;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $url = (string) $url;

        if (substr($url, -1) !== '/') {
            $url .= '/';
        }

        $this->url = $url;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function setMethods(array $methods)
    {
        $this->methods = $methods;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function setFilters(array $filters, $parametersByName = false)
    {
        $this->filters = $filters;
        $this->parametersByName = $parametersByName;
    }

    public function getRegex()
    {
        return preg_replace_callback('/(:\w+)/', array(&$this, 'substituteFilter'), $this->url);
    }

    private function substituteFilter($matches)
    {
        if (isset($matches[1], $this->filters[$matches[1]])) {
            return $this->filters[$matches[1]];
        }

        return '([\w-%]+)';
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function dispatch()
    {
        $action = explode('::', $this->config['_controller']);
        $instance = new $action[0];

        if ($this->parametersByName) {
            $this->parameters = array($this->parameters);
        }

        if (empty($action[1]) || trim($action[1]) === '') {
            call_user_func_array($instance, $this->parameters);

            return;
        }

        call_user_func_array(array($instance, $action[1]), $this->parameters);
    }

    public function getAction()
    {
        return $this->action;
    }

}
