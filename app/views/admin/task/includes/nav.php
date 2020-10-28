<?php
use libs\UrlManager;
?>
<div class="row">
  <div class="col-12">
    <div class="my-3">
      <?php if (!UrlManager::isPage('admin/task/list')): ?>
      <a href="javascript:history.go(-1)"
        class="btn btn-light">&larr; to back</a>
      <?php endif; ?>
      <?php if (!UrlManager::isPage('admin/task/new')): ?>
      <a href="<?= UrlManager::link('admin/task/new') ?>"
        class="btn btn-light">+ add new</a>
      <?php endif; ?>
      <?php if (!UrlManager::isPage('admin/task/list')): ?>
      <a href="<?= UrlManager::link('admin/task/list') ?>"
        class="btn btn-light">list</a>
      <?php endif; ?>
    </div>
  </div>
</div>