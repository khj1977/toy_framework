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
  TheWorld::instance()->htmlDebugStream->render();
?>

<!-- </section> -->
</div>

<script src="./jquery/jquery.js"></script>
<script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>