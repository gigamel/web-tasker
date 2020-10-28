<?php
use libs\UrlManager;
?>
<div class="content">
  <div class="container">
    <?php require_once 'includes/nav.php'; ?>
    <div class="row">
      <div class="col-12">
      <?php if (empty($tasks)): ?>
        <p>List tasks is empty.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>{ID}</th>
                <th>{USER}</th>
                <th>{STATUS}</th>
                <th>{EMAIL}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tasks as $task): ?>
              <tr>
                <td>#<?= $task->id ?></td>
                <td><?= $task->login ?></td>
                <td><?= isset($statuses[$task->status]) ? $statuses[$task->status] : '' ?></td>
                <td><?= $task->email ?></td>
                <td>
                  <a href="<?= UrlManager::link('admin/task/edit&id=' . $task->id) ?>">[edit]</a>
                  <a href="<?= UrlManager::link('admin/task/delete&id=' . $task->id) ?>">[delete]</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?= $pagination->widget() ?>
      <?php endif; ?>
      </div>
    </div>
  </div>
</div>