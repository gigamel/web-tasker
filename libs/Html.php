<?php
namespace libs;

class Html
{
    /**
     * @param string $html
     * @return string
     */
    public static function encode($html = '')
    {
        $html = is_string($html) ? $html : '';
        
        return empty($html) ? '' : str_replace(PHP_EOL,
            '<br>', htmlspecialchars($html));
    }
}