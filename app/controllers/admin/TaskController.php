<?php
namespace app\controllers\admin;

use abstractions\Controller;
use app\models\Task;
use widgets\Pagination;
use libs\UrlManager;

class TaskController extends Controller
{
    /**
     * @var string $layout
     */
    public $viewLayout = 'admin';

    public function actionList()
    {
        $model = new Task();

        $totalCount = $model->getAllCount();

        $pagination = new Pagination([
            'limit' => 3,
            'total' => $totalCount,
            'query' => 'per-page'
        ]);
  
        $tasks = $model->joinWith('user', NULL, 'ON task.userId = user.id',
            'task.*, user.login, user.email', 'ORDER BY id DESC',
            $pagination->limit, $pagination->offset);
        
        $statuses = $model->statuses;

        $this->setTitle('Task manager');

        $this->render('admin/task/index', [
            'tasks' => $tasks,
            'pagination' => $pagination,
            'statuses' => $statuses
        ]);
    }

    /**
     * @param int $id
     */    
    public function actionDelete($id = null)
    {
        $task = null;

        $id = (int) $id;
        if ($id > 0) {
            $model = new Task();

            $task = $model->getById($id);
        }
        
        if (is_null($task)) {
            $this->redirect(UrlManager::link('admin/task/list'));
        } else {
            if (isset($_POST['confirm'])) {
                $task->delete();
                
                $this->redirect(UrlManager::link('admin/task/list'));
            }
            
            $this->setTitle('Delete task #' . $task->id);

            $this->render('admin/task/delete', [
                'task' => $task
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
            $model = new Task();

            $task = $model->getById($id);
        }

        if (is_null($task)) {
            $this->redirect(UrlManager::link('admin/task/list'));
        } else {
            $user = \Application::$app->user;
            
            if (isset($_POST['save'])) {
                $task->loadFromArray([
                    'userId' => $_POST['userId'],
                    'description' => $_POST['description'],
                    'status' => $_POST['status']
                ]);
                
                if (empty($task->description)) {
                    $this->pushError('the task is empty');
                } else {
                    $task->update();
                    
                    $_SESSION['message'] = 'task updated successfully';
                    
                    $this->redirect(UrlManager::link("admin/task/edit"
                        . "&id={$task->id}"));
                }
            }
            
            $users = $user->getList();
            
            $statuses = $task->statuses;
            
            $this->setTitle('Edit task #' . $task->id);

            $this->render('admin/task/edit', [
                'task' => $task,
                'users' => $users,
                'statuses' => $statuses
            ]);
        }
    }

    public function actionNew()
    {
        $task = new Task();
        
        $user = \Application::$app->user;
        
        $users = $user->getList();
        
        if (isset($_POST['save'])) {
            $task->loadFromArray([
                'userId' => $_POST['userId'],
                'description' => $_POST['description'],
                'status' => $_POST['status']
            ]);
            
            if (empty($task->description)) {
                $this->pushError('the task is empty');
            } else {
                $taskId = $task->insert();
                if ((int) $taskId > 0) {
                    $_SESSION['message'] = 'task added successfully';
                    
                    $this->redirect(UrlManager::link("admin/task/edit"
                        . "&id={$taskId}"));
                } else {
                    $this->pushError('error when adding the new task');
                }
            }
        }
        
        $statuses = $task->statuses;
        
        $this->setTitle('New task');

        $this->render('admin/task/new', [
            'task' => $task,
            'users' => $users,
            'statuses' => $statuses
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