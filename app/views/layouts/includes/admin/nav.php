<?php
use libs\UrlManager;
?>
<div class="header">
  <div class="container">
    <div class="row">
      <div class="col-12 text-right">
        <a href="/" class="btn btn-outline-primary">Homepage</a>
        <?php if (!UrlManager::isPage('admin/task/list')): ?>
        <a href="<?= UrlManager::link('admin/task/list') ?>"
          class="btn btn-outline-primary">Task manager</a>
        <?php endif; ?>
        <?php if (!UrlManager::isPage('admin/user/list')): ?>
        <a href="<?= UrlManager::link('admin/user/list') ?>"
          class="btn btn-outline-primary">User manager</a>
        <?php endif; ?>
        <a href="<?= UrlManager::link('login/sign-out') ?>"
          class="btn btn-outline-primary"><?= \Application::$app->user->login ?></a>
      </div>
    </div>
  </div>
</div>