<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css"> 

<title>Error</title>

<body>

<div class="container">
<!-- <section> -->
<?php
  TheWorld::instance()->renderingArea->renderOn(TheWorld::instance()->htmlDebugStream->render());
?>

<center>
  <div class="card w-75">
    <div class="card-body">
      <p class="card-text">An error has been occurred</p>
    </div>
  </div>
</center>'

<!-- </section> -->
</div>

<script src="./jquery/jquery.js"></script>
<script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>