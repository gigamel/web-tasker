<?php
namespace app\controllers;

use abstractions\Controller;
use app\models\Task;
use widgets\Pagination;
use libs\UrlManager;

class TaskController extends Controller
{
    public function actionIndex()
    {
        $model = new Task();

        $totalCount = $model->getAllCount();

        $pagination = new Pagination([
            'limit' => 3,
            'total' => $totalCount,
            'query' => 'per-page'
        ]);

        $tasks = $model->getList($pagination->limit, $pagination->offset,
            'ORDER BY id DESC');

        $this->setTitle('Home Tasker!');

        $this->render('task/index', [
            'tasks' => $tasks,
            'pagination' => $pagination
        ]);
    }
    
    public function actionNew()
    {
        $task = new Task();
        
        if (isset($_POST['save'])) {
            $task->loadFromArray([
                'userName' => $_POST['userName'],
                'description' => $_POST['description'],
                'email' => $_POST['email']
            ]);
            
            if (empty($task->description)) {
                $this->pushError('task description is too short');
            }

            if (!preg_match('#^[a-z0-9]{3,}$#', $task->userName)) {
                $this->pushError('userName is not valid');
            }

            if (!filter_var($task->email, FILTER_VALIDATE_EMAIL)) {
                $this->pushError('email is not valid');
            }
            
            if (!$this->hasErrors()) {
                $taskId = $task->insert();
                if ((int) $taskId > 0) {
                    $this->redirect('/');
                } else {
                    $this->pushError('error when adding the new task');
                }
            }
        }
        
        $this->setTitle('New task');

        $this->render('task/new', [
            'task' => $task
        ]);
    }
}