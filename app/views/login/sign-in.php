<?php
use libs\UrlManager;
?>
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <form class="sign-in-form" action="<?= UrlManager::link() ?>"
          method="POST" autocomplete="off">
          <?php if ($this->hasErrors()): ?>
          <div class="text-center">
            <div class="border border-danger p-3 my-3 text-danger"><?= implode('<br>', $this->errors); ?></div>
          </div>
          <?php endif; ?>
          <div class="form-group">
            <input type="text" class="form-control" name="login" value="<?= $user->login ?>"
              placeholder="Login" maxlength="20">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password"
              placeholder="Password">
          </div>
          <input type="submit" class="btn btn-lg btn-primary btn-block"
            name="confirm" value="Confirm">
          <br>
          <p class="text-right">
            <a href="/">to site &larr;</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>