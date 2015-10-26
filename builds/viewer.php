<?php
$_PAGETITLE = "Glass | Build Viewer";
include(realpath(dirname(__DIR__) . "/private/header.php"));
?>

<canvas id="canvas">
	If you can see this, your browser may not support HTML 5
</canvas>

<div id="overlay" onclick = "NBL.pop_menu();">
</div>

<div id="overlay_info">
	<a id="overlay_close" href="javascript:NBL.pop_menu();">Close</a>
	<h2>Escape Menu</h2>
	<input type="file" id="files" name="files[]"/><br>
	<output id="list"></output><br>
	<button type="button" onclick="NBL.pop_menu();">Close</button>
</div>

<div id="viewer_nav_container">
<?php include(realpath(dirname(__DIR__) . "/private/navigationbar.php")); ?>
</div>

<script src="./res/babylon.js"></script>
<link rel="stylesheet" href="./res/NBL.css">
<script type="text/javascript">
<?php
$testfile = "./res/House.bls";
echo("var targetUrl = \"" . $testfile . "\";");
?>
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="./res/NBL.js"></script>

<?php include(realpath(dirname(__DIR__) . "/private/footer.php")); ?>