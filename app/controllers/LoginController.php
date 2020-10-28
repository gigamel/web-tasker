<?php
namespace app\controllers;

use Application;
use abstractions\Controller;
use libs\UrlManager;

class LoginController extends Controller
{
    /**
     * @var string $layout
     */
    public $viewLayout = 'login';

    public function actionSignIn()
    {
        $user = Application::$app->user;
        
        $authorized = false;
        
        if ($user->isAuthorized()) {
            $authorized = true;
        }
        
        if (isset($_POST['confirm'])) {
            $user->loadFromArray([
                'login' => $_POST['login'],
                'password' => $_POST['password']
            ]);
            
            if ($user->authorize()) {
                $this->redirect(UrlManager::link('admin/task/list'));
            } else {
                $this->pushError('data entered incorrectly');
            }
        }

        if ($authorized) {
            $this->redirect('/');
        }

        $this->render('login/sign-in', [
            'user' => $user
        ]);
    }
    
    public function actionSignOut()
    {
        $user = Application::$app->user;
        
        $authorized = false;
        
        if ($user->isAuthorized()) {
            $authorized = true;
        }
        
        if ($authorized === false) {
            $this->redirect(UrlManager::link('login/sign-out'));
        }
        
        if (isset($_POST['confirm'])) {
            $user->logout();
            
            $this->redirect('/');
        }
        
        $this->setTitle('Logout');
        
        $this->render('login/sign-out');
    }
}