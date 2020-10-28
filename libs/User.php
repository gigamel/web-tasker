<?php
namespace libs;

class User extends \app\models\User
{
    /**
     * @return boolean
     */
    public function authorize()
    {
        $user = $this->getByHash();
        if (empty($user)) {
            return false;
        }
        
        $this->setAuthorizeData();

        return true;
    }
    
    /**
     * @return boolean
     */
    public function isAuthorized()
    {
        return isset($_SESSION['user']) ? true : false;
    }
    
    public function logout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
    }

    public function setAuthorizeData()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = [
                'h' => $this->hash,
                'l' => $this->login,
                'e' => $this->email
            ];
        }
    }

    public function __construct()
    {
        parent::__construct();
        
        if ($this->isAuthorized()) {
            $this->hash = $_SESSION['user']['h'];
            $this->login = $_SESSION['user']['l'];
            $this->email = $_SESSION['user']['e'];
        }
    }
}