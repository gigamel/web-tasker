<?php
namespace libs;

final class Db
{
    /**
     * @var object $instance
     */
    public static $instance;

    /**
     * @var object $db
     */
    public $db;

    /**
     * @return object
     */
    public static function createObject()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        
        return static::$instance;
    }

    private function loadDbSettings()
    {
        $settings = \Application::$app->getOption('db');        
        if (!is_null($settings)) {
            if (isset($settings['server']) && isset($settings['host'])
                && isset($settings['name']) && isset($settings['charset'])
                && isset($settings['user']) && isset($settings['password'])) {
                $dsn = "{$settings['server']}:host={$settings['host']};";
                $dsn .= "dbname={$settings['name']};";
                $dsn .= "charset={$settings['charset']}";
            
                $user = $settings['user'];
            
                $password = $settings['password'];
                
                try {
                    $this->db = new \PDO($dsn, $user, $password);
                } catch (\PDOException $e) {
                    $this->db = null;
                }
            }
        }
    }

    private function __construct()
    {
        $this->loadDbSettings();
    }
}