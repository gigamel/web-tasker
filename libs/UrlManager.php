<?php
namespace libs;

class UrlManager
{
    /**
     * @param string $path
     * @return string
     */
    public static function link($path = '')
    {
        return (is_string($path)
            && !empty($path)) ? '/index.php?' . \Application::$app->query . '=' . $path : '';
    }

    /**
     * @param string $path
     * @return boolean
     */
    public static function isPage($path = '')
    {
        $path = is_string($path) ? $path : '';
        
        return $path == \Application::$app->route;
    }
}