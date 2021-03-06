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
      <input type="hidden" name="status" value="<?= $task->status ?>">
      <div class="row">
        <div class="col-md-9">
          <div class="form-group">
            <textarea name="description" class="form-control" rows="15"
              placeholder="Description"><?= $task->description ?></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <select name="status" class="form-control">
              <?php foreach ($statuses as $id => $status): ?>
              <option value="<?= $id ?>"<?php if ($id == $task->status): ?> selected<?php endif; ?>><?= $status ?></option>
              <?php endforeach; ?>
            </select>
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