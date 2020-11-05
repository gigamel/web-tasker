<?php
use libs\UrlManager;
use libs\Html;
?>
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Task list</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
      <?php if (empty($tasks)): ?>
        <p>List tasks is empty.</p>
      <?php else: ?>
        <?php foreach ($tasks as $task): ?>
        <div class="row">
          <div class="col-md-12">
            <div class="bg-light text-dark p-3 my-3 h4">
              Task #<?= $task->id ?>
              <?php if (\Application::$app->user->isAuthorized()): ?>
              <a href="<?= UrlManager::link("admin/task/edit&id={$task->id}") ?>">[edit]</a>
              <a href="<?= UrlManager::link("admin/task/delete&id={$task->id}") ?>">[delete]</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="p-3">
              <p><strong>User:</strong> <?= $task->userName ?></p>
              <p><strong>E-mail:</strong> <?= $task->email ?></p>
              <p><strong>Status:</strong> <?= ((int) $task->status == 0) ? '<span class="text-success">done</span>' : '<span class="text-warning">on work</span>' ?></p>
            </div>
          </div>
          <div class="col-md-8">
            <div class="p-3 text-muted"><?= Html::encode($task->description) ?></div>
          </div>
        </div>
        <?php endforeach; ?>
        <?= $pagination->widget() ?>
      <?php endif; ?>
      </div>
    </div>
  </div>
</div>