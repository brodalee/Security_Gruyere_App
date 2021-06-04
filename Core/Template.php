<?php

namespace Core;

use Exception;

class Template
{
    private $content;

    private function initFileContent(string $fileName)
    {
        $path = 'src/templates/' . $fileName;
        if (file_exists($path)) {
            $this->content = file_get_contents($path);
            return;
        }
        throw new Exception('File dont exist');
    }

    public function render(string $fileName, array $params = [])
    {
        $this->initFileContent($fileName);
        $this->interpolateUseFile($params);
        $this->interpolate(array_filter($params, function ($p) {
            return is_string($p) || is_int($p) || is_float($p);
        }));
        $this->interpolateLoop(array_filter($params, function ($p) {
            return is_array($p);
        }));
        $this->interpolateObject(array_filter($params, function($p) {
            return is_object($p);
        }));
        $this->interpolateRoutes();
        $this->interpolateFlashMessage();
        return $this->content;
    }

    private function interpolate(array $params)
    {
        foreach ($params as $name => $value) {
            $this->content = str_replace("{{ $name }}", $value, $this->content);
        }
    }

    private function interpolateObject(array $params)
    {
        foreach ($params as $name => $value) {
            preg_match_all("/$name->[a-zA-Z0-9]+/", $this->content, $matches);
            foreach ($matches[0] as $globalMatch) {
                $property = str_replace("$name->", "", $globalMatch);
                $this->content = str_replace("$$name->$property", $value->$property, $this->content);
            }
        }
    }

    private function interpolateLoop(array $params)
    {
        foreach ($params as $name => $value) {
            if (preg_match_all("/{{ loop " . $name . " with \"[a-zA-Z0-9_.-\/]+\" }}/", $this->content, $matches)) {
                foreach ($matches[0] as $globalMatch) {
                    $template_name = $this->getStringBetween($globalMatch, '"', '"');
                    if (file_exists($template_name)) {
                        $string_to_replace = '{{ loop ' . $name . ' with "' . $template_name . '" }}';
                        $final_content = "";
                        $base_content = file_get_contents($template_name);
                        foreach ($value as $vValue) {
                            // Dans le cas ou c'est un objet (accès public seulement).
                            if (preg_match_all("/$name->[a-zA-Z0-9]+/", $base_content, $base_matches)) {
                                $newContent = $base_content;
                                foreach ($base_matches[0] as $match) {
                                    $property = str_replace("$name->", "", $match);
                                    $newContent = str_replace("$$name->$property", $vValue->$property, $newContent);
                                }
                                $final_content .= $newContent;
                            }
                            // Dans le cas ou le contene n'est pas un objet (string, int ...).
                            else if (preg_match_all("/$name/", $base_content, $base_matches)) {
                                $newContent = $base_content;
                                foreach ($base_matches[0] as $match) {
                                    $newContent = str_replace("$$name", $vValue, $newContent);
                                }
                                $final_content .= $newContent;
                            }
                        }
                        $this->content = str_replace($string_to_replace, $final_content, $this->content);
                        break;
                    }
                    throw new Exception("file $template_name dont exist");
                }
            }
        }
    }

    private function getStringBetween(string $string, string $start, string $end): string
    {
        $string = '' . $string;
        $ini = strpos($string, $start);
        if ($ini === 0) {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        $sub = substr($string, $ini, $len);
        $sub = str_replace(array('{{', '}}'), '', $sub);
        return trim($sub);
    }

    private function interpolateRoutes()
    {
        if (preg_match_all('/\{{2}[ ]route::[a-zA-Z\.0-9]+[ ]}{2}/', $this->content, $matches)) {
            if (!empty($matches[0])) {
                $routes = include './Config/routes.php';
                foreach ($matches[0] as $match) {
                    $name = $this->getStringBetween($match, '::', ' }}');
                    $route = array_filter($routes, function ($p) use($name) {
                        return $p['name'] === $name;
                    });
                    $route = array_values($route);
                    if (isset($route[0])) {
                        $this->content = str_replace($match, $route[0]['path'], $this->content);
                    }
                }
            }
        }
    }

    public function interpolateFlashMessage()
    {
        if (preg_match_all('/\{{2}[ ]flash::[a-zA-Z\.0-9_]+::[a-zA-Z\.\/0-9]+[ ]}{2}/', $this->content, $matches)) {
            if (!empty($matches[0])) {
                foreach ($matches[0] as $match) {
                    $name = $this->getStringBetween($match, '::', '::');
                    if (isset($_SESSION['flashes'][$name])) {
                        $template = str_replace($name.'::', '', $this->getStringBetween($match, '::', ' }}'));
                        $tpl = new Template();
                        $flashContent = $tpl->render('flash/' . $template, [
                            'message' => $_SESSION['flashes'][$name]
                        ]);
                        unset($_SESSION['flashes'][$name]);
                        $this->content = str_replace($match, $flashContent, $this->content);
                    } else {
                        $this->content = str_replace($match, '', $this->content);
                    }
                }
            }
        }
    }

    public function interpolateUseFile(array $params)
    {
        if (preg_match_all('/{{2}[ ]use::[a-zA-Z0-9\-._]+[ ]}{2}/', $this->content, $matches)) {
            if (!empty($matches[0])) {
                foreach ($matches[0] as $match) {
                    $templateName = $this->getStringBetween($match, '::', ' }}');
                    $tpl = new Template();
                    $content = $tpl->render($templateName, $params);
                    $this->content = str_replace($match, $content, $this->content);
                }
            }
        }
    }
}