<?php
use libs\UrlManager;
?>
<div class="content">
  <div class="container">
    <?php require_once 'includes/nav.php'; ?>
    <div class="row">
      <div class="col-12">
        <form action="<?= UrlManager::link() ?>" method="POST"
          autocomplete="off">
          <h2>Delete task #<?= $task->id ?>?</h2>
          <input type="submit" class="btn btn-primary"
            name="confirm" value="Confirm">
          <a href="javascript:history.go(-1)" class="btn btn-light">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>