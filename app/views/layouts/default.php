<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?= $TITLE_VIEW ?></title>
    <link rel="stylesheet" href="/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="/frontend/css/style.css">
  </head>
  <body>
    <?php require_once 'includes/nav.php'; ?>
    <?= $CONTENT_VIEW ?>
  </body>
</html>