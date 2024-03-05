<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css"> 
<link rel="stylesheet" href="/css/style.css"> 

<link href="/jquery-ui/jquery-ui.css" rel="stylesheet">

<script>
	$( function() {
	  $( "#datepicker" ).datepicker();
	} );
</script>

<title>SampleKListView</title>
</head>

<body>

<div class="container">
<!-- <section> -->
<?php
  TheWorld::instance()->renderingArea->renderOn(TheWorld::instance()->htmlDebugStream->render());
?>

<?php
  TheWorld::instance()->renderingArea->renderOn($subView->render());
?>

<!-- </section> -->
</div>

<script src="/jquery/jquery.js"></script>
<script src="/jquery-ui/jquery-ui.js"></script>
<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
$( "#accordion" ).accordion();

$( "#datepicker" ).datepicker({
	inline: true
});
</script>


</body>

</html>