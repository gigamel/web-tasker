<?php
use libs\UrlManager;
?>
<div class="header">
  <div class="container">
    <div class="row">
      <div class="col-12 text-right">
      <?php if (UrlManager::isPage('task/new')): ?>
        <a href="/" class="btn btn-outline-primary">Homepage</a>
      <?php else: ?>
        <a href="<?= UrlManager::link('task/new') ?>"
          class="btn btn-outline-primary">New task</a>
      <?php endif; ?>
      <?php if (\Application::$app->user->isAuthorized()): ?>
        <a href="<?= UrlManager::link('admin/task/list') ?>"
          class="btn btn-outline-primary">Task manager</a>
        <a href="<?= UrlManager::link('admin/user/list') ?>"
          class="btn btn-outline-primary">User manager</a>
        <a href="<?= UrlManager::link('login/sign-out') ?>"
          class="btn btn-outline-primary"><?= \Application::$app->user->login ?></a>
      <?php else: ?>
        <a href="<?= UrlManager::link('login/sign-in') ?>"
          class="btn btn-outline-primary">Sign in</a>
      <?php endif; ?>
      </div>
    </div>
  </div>
</div>