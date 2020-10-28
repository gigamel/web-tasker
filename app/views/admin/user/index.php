<?php
use libs\UrlManager;
?>
<div class="content">
  <div class="container">
    <?php require_once 'includes/nav.php'; ?>
    <div class="row">
      <div class="col-12">
      <?php if (empty($users)): ?>
        <p>List tasks is empty.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>{ID}</th>
                <th>{USER}</th>
                <th>{EMAIL}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user): ?>
              <tr>
                <td>#<?= $user->id ?></td>
                <td><?= $user->login ?></td>
                <td><?= $user->email ?></td>
                <td>
                  <a href="<?= UrlManager::link('admin/user/edit&id=' . $user->id) ?>">[edit]</a>
                  <a href="<?= UrlManager::link('admin/user/delete&id=' . $user->id) ?>">[delete]</a>
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