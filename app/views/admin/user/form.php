<?php
use libs\UrlManager;
?>
<?php if ($this->hasErrors()): ?>
<div class="row">
  <div class="col-12 text-danger">
    <div class="border border-danger p-3 my-3">
      <?= implode('<br>', $this->errors); ?>
    </div>
  </div>
</div>
<?php endif; ?>
<?php if ($this->hasMessage()): ?>
<div class="row">
  <div class="col-12 text-success">
    <div class="border border-success p-3 my-3">
      <?= $this->message ?>
    </div>
  </div>
</div>
<?php endif; ?>
<div class="row">
  <div class="col-12">
    <form action="<?= UrlManager::link() ?>" method="POST"
      autocomplete="off">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <input type="text" name="login" value="<?= $user->login ?>"
              class="form-control" placeholder="Login">
          </div>
          <div class="form-group">
            <input type="email" name="email" value="<?= $user->email ?>"
              class="form-control" placeholder="E-mail">
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control"
              placeholder="Password">
          </div>
          <div class="form-group">
            <input type="password" name="confirmPassword"
              class="form-control" placeholder="Confirm password">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <input type="submit" class="btn btn-primary" name="save"
            value="Save">
        </div>
      </div>
    </form>
  </div>
</div>