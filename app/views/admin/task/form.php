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
      <input type="hidden" name="userId" value="<?= $task->userId ?>">
      <input type="hidden" name="status" value="<?= $task->status ?>">
      <div class="row">
        <div class="col-md-9">
          <div class="form-group">
            <textarea name="description" class="form-control" rows="7"
              placeholder="Description"><?= $task->description ?></textarea>
          </div>
        </div>
        <?php if (!empty($users)): ?>
        <div class="col-md-3">
          <div class="form-group">
            <select name="userId" class="form-control">
              <?php foreach ($users as $user): ?>
              <option value="<?= $user->id ?>"<?php if ($user->id == $task->userId): ?> selected<?php endif; ?>><?= $user->login ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <select name="status" class="form-control">
              <?php foreach ($statuses as $id => $status): ?>
              <option value="<?= $id ?>"<?php if ($id == $task->status): ?> selected<?php endif; ?>><?= $status ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <?php endif; ?>
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