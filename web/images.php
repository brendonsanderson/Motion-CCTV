<?php 
session_start();
if (isset($_SESSION['logged_in'])) {
} else {
	header("Location: ./login");
	}
?>
<!DOCTYPE html>

<html>
    <title>Images</title>
	<link rel="stylesheet" href="./files/index.css?version5.5">
</head>		

			<div class="project-row header">
		<div class="desc">
			<div class="name">
				<span class="meta">Navigation</span>
				<p><a href="./main">Back</a></p>
			</div>
			<div class="year">
				<span class="meta">User</span>
				<p><a href="./logout">Logout</a></p>
			</div>
				</div>
				</div>	
<body>
	<center></br>
	<h3>Images</h3>
<div id="content-wrapper">
</br>

	<?
	$dirname = "files/images/";
	$images = glob($dirname."*.jpg");
	
	foreach($images as $image) {
		echo '<img src="'.$image.'" />';
	}
	?>
	
</div>
</center>	
</body>

</html>