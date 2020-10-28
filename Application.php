<?php
use abstractions\Singleton;

class Application extends Singleton
{
    /**
     * @var string $defaultController
     */
    public $defaultController = 'site';

    /**
     * @var string $defaultAction
     */
    public $defaultAction = 'index';

    /**
     * @var string $query
     */
    public $query = 'route';

    /**
     * @var string $route
     */
    public $route = '';

    /**
     * @var array $_settings
     */
    protected $_settings = [];

    /**
     * @var array $settings
     */
    protected $settings = [];

    /**
     * @var boolean $started
     */
    protected $started = false;

    /**
     * @param string $dotsPath
     */
    final public function getOption($dotsPath = null)
    {
        $value = null;

        $dotsPath = is_string($dotsPath) ? $dotsPath : null;
        if (!is_null($dotsPath)) {
            $keys = explode('.', $dotsPath);
            foreach ($keys as $key) {
                if (is_null($value)) {
                    if (isset($this->settings[$key])) {
                        $value = $this->settings[$key];
                    } else {
                        break;
                    }
                } else {
                    if (isset($value[$key])) {
                        $value = $value[$key];
                    } else {
                        break;
                    }
                }
            }
        }
        
        return $value;
    }

    /**
     * @param string $type
     * @return $this
     */
    final public function loadSettings($type = null)
    {
        if (is_string($type)) {
            if (!isset($this->_settings[$type])) {
                $settingsFile = __DIR__ . '/settings/' . $type . '.php';
                if (file_exists($settingsFile)) {
                    $settings = require_once($settingsFile);
                    if (is_array($settings)) {
                        $this->_settings[$type] = true;
                        $this->settings[$type] = array_merge($settings, $this->settings);
                    }
                }
            }
        }

        return $this;
    }

    protected function loadComponents()
    {
        $components = [
            'user' => '\\libs\\User'
        ];
        
        foreach ($components as $id => $component) {
            if (is_string($id) && is_string($component)
                && !property_exists($this, $id)) {
                $this->$id = new $component;
            }
        }
    }

    /**
     * @return void
     */
    public function run()
    {
        session_start();
        
        $this->loadComponents();
        
        $controllerPrefix = '';
        
        $route = isset($_GET[$this->query]) ? $_GET[$this->query] : '';
        if (empty($route)) {
            $actionId = $this->defaultAction;
            $controllerId = $this->defaultController;
        } else {
            $this->route = $route;
            
            unset($_GET[$this->query]);
            
            $partsRoute = explode('/', $route);
            if (count($partsRoute) > 1) {
                $actionId = array_pop($partsRoute);
                $controllerId = array_pop($partsRoute);
            }

            if (count($partsRoute) > 0) {
                $controllerPrefix = implode('\\', $partsRoute) . '\\';
            }
        }

        if ($this->isValidPartRoute($controllerId)
            && $this->isValidPartRoute($actionId)) {
            $controllerName = '\\app\\controllers\\' . $controllerPrefix
                . str_replace('-', '', ucwords($controllerId, '-'))
                . 'Controller';

            $controller = new $controllerName;
                
            $action = 'action' . str_replace('-', '', ucwords($actionId, '-'));
            if (!method_exists($controller, $action)) {
                die("action: <b>{$action}</b> does not exist.");
            }

            call_user_func_array([$controller, $action], $_GET);
        } else {
            die("route: <b>{$route}</b> not found.");
        }
    }

    /**
     * @param string $value
     * @return $this
     */
    final public function setDefaultAction($value)
    {
        return $this->setObjectProperty('defaultAction', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    final public function setDefaultController($value)
    {
        return $this->setObjectProperty('defaultController', $value);
    }

    /**
     * @param string $value
     * @return $this
     */
    final public function setRouteVar($value)
    {
        return $this->setObjectProperty('query', $value);
    }

    /**
     * @param string $partRoute
     * @return boolean
     */
    final protected function isValidPartRoute($partRoute = '')
    {
        $partRoute = is_string($partRoute) ? $partRoute : '';

        $parts = explode('-', $partRoute);
        foreach ($parts as $part) {
            $firstLetter = mb_substr($part, 0, 1);
            if ($firstLetter == strtoupper($firstLetter)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    final protected function setObjectProperty($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }

        return $this;
    }
}