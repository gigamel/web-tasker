<?php
namespace app\controllers\admin;

use abstractions\Controller;
use widgets\Pagination;
use app\models\User;
use libs\UrlManager;

class UserController extends Controller
{
    /**
     * @var string $layout
     */
    public $viewLayout = 'admin';

    public function actionList()
    {
        $model = \Application::$app->user;
        
        $totalCount = $model->getAllCount();

        $pagination = new Pagination([
            'limit' => 3,
            'total' => $totalCount,
            'query' => 'per-page'
        ]);
        
        $users = $model->getList($pagination->limit, $pagination->offset,
            'ORDER BY id DESC');
        
        $this->setTitle('User manager');
        
        $this->render('admin/user/index', [
            'users' => $users,
            'pagination' => $pagination
        ]);
    }

    /**
     * @param int $id
     */    
    public function actionDelete($id = null)
    {
        $user = null;

        $id = (int) $id;
        if ($id > 0) {
            $model = new User();

            $user = $model->getById($id);
        }
        
        if ($user === null) {
            $this->redirect(UrlManager::link('admin/user/list'));
        } else {
            if (isset($_POST['confirm'])) {
                $user->delete();
                
                $this->redirect(UrlManager::link('admin/user/list'));
            }
            
            $this->setTitle('Delete user' . $user->login);

            $this->render('admin/user/delete', [
                'user' => $user
            ]);
        }
    }

    /**
     * @param int $id
     */
    public function actionEdit($id = null)
    {
        $task = null;

        $id = (int) $id;
        if ($id > 0) {
            $model = new User();

            $user = $model->getById($id);
        }

        if ($user === null) {
            $this->redirect(UrlManager::link('admin/user/list'));
        } else {
            if (isset($_POST['save'])) {
                $user->loadFromArray([
                    'login' => trim($_POST['login']),
                    'email' => $_POST['email'],
                    'password' => htmlspecialchars(trim($_POST['password'])),
                    'confirmPassword' => htmlspecialchars(
                        $_POST['confirmPassword'])
                ]);
                
                if (empty($user->login)) {
                    $this->pushError('the user is empty');
                }
                
                if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                    $this->pushError('email of user is empty');
                }
                
                if (!empty($user->password)) {
                    if ($user->password !== $user->confirmPassword) {
                        $this->pushError('Invalid password');
                    }
                }
                    
                if (!$this->hasErrors()) {
                    $user->update();
                    
                    $_SESSION['message'] = 'user updated successfully';
                    
                    $this->redirect(UrlManager::link("admin/user/edit"
                        . "&id={$user->id}"));
                }
            }
            
            $this->setTitle('Edit user ' . $user->login);

            $this->render('admin/user/edit', [
                'user' => $user
            ]);
        }
    }

    public function actionNew()
    {
        $user = new User();
        
        if (isset($_POST['save'])) {
            $user->loadFromArray([
                'login' => trim($_POST['login']),
                'email' => $_POST['email'],
                'password' => htmlspecialchars(trim($_POST['password'])),
                'confirmPassword' => htmlspecialchars($_POST['confirmPassword'])
            ]);

            if (empty($user->login)) {
                $this->pushError('invalid login');
            }

            if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                $this->pushError('invalid email');
            }

            if (empty($user->password)
                || $user->password !== $user->confirmPassword) {
                $this->pushError('invalid password');
            }

            if (!$this->hasErrors()) {
                $userId = $user->insert();
                if ((int) $userId > 0) {
                    $_SESSION['message'] = 'user added successfully';
                    
                    $this->redirect(UrlManager::link("admin/user/edit"
                        . "&id={$userId}"));
                } else {
                    $this->pushError('error when adding the new user');
                }
            }
        }
  
        $this->setTitle('New user');

        $this->render('admin/user/new', [
            'user' => $user
        ]);
    }

    public function __construct()
    {
        if (!\Application::$app->user->isAuthorized()) {
            $this->redirect(UrlManager::link('login/sign-in'));
        }
        
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            
            unset($_SESSION['message']);
        }
    }
}