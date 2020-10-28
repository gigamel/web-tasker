<?php
use libs\UrlManager;
?>
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <form action="<?= UrlManager::link() ?>" method="POST"
          autocomplete="off">
          <h2>Logout from system?</h2>
          <input type="submit" class="btn btn-primary"
            name="confirm" value="Confirm">
          <a href="/" class="btn btn-light">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>