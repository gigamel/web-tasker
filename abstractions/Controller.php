<?php
namespace abstractions;

abstract class Controller extends Base
{
    /**
     * @var array $access
     */
    public $access = [];
    /**
     * @var string $message
     */
    public $message;

    /**
     * @var array $errors
     */
    public $errors = [];

    /**
     * @var string $layout
     */
    public $viewLayout = 'default';

    /**
     * @var string $viewTitle
     */
    public $viewTitle = '';

    /**
     * @param string $viewName
     * @param array $vars
     */
    public function render($viewName, $vars = [])
    {
        if (strpos($viewName, '..') !== false) {
            return;
        }
        
        $CONTENT_VIEW = '';

        $viewDir = dirname(getenv('DOCUMENT_ROOT')) . '/app/views';
        $viewFile = $viewDir . '/' . $viewName . '.php';
        if (file_exists($viewFile)) {
            $vars = is_array($vars) ? $vars : [];
            extract($vars);
            ob_start();
            require_once $viewFile;
            $CONTENT_VIEW = ob_get_contents();
            ob_end_clean();
        }
        
        $viewFile = $viewDir . '/layouts/' . $this->viewLayout . '.php';
        if (file_exists($viewFile)) {
            $TITLE_VIEW = $this->viewTitle;
            require_once $viewFile;
        }
    }
    
    /**
     * @return boolean
     */
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }
    
    /**
     * @return boolean
     */
    public function hasMessage()
    {
        return is_null($this->message) === false;
    }

    /**
     * @param string $message
     */
    public function pushError($message = '')
    {
        $message = is_string($message) ? $message : '';
        
        $this->errors[] = $message;
    }

    /**
     * @param string $path
     */
    public function redirect($path = '/')
    {
        $path = is_string($path) ? trim($path) : '';
        $path = empty($path) ? getenv('REQUEST_URI') : $path;

        header("Location:{$path}");
        die;
    }

    /**
     * @param string $title
     */
    protected function setTitle($title = '')
    {
        $this->viewTitle = is_string($title) ? $title : '';
    }
}