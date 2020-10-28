<?php
namespace app\controllers;

use abstractions\Controller;
use app\models\Task;
use widgets\Pagination;

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

        $tasks = $model->joinWith('user', NULL, 'ON task.userId = user.id',
            'task.*, user.login, user.email', 'ORDER BY id DESC',
            $pagination->limit, $pagination->offset);

        $this->setTitle('Home Tasker!');

        $this->render('task/index', [
            'tasks' => $tasks,
            'pagination' => $pagination
        ]);
    }
}