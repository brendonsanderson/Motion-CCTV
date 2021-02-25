<?php
  session_start();
  session_destroy();
  header("Location: ./welcome");
?>
<html>
    <title>Error</title>
	<link rel="stylesheet" href="./files/index.css?version5.5">	
<body>
	<center>
<div id="content-wrapper">
</br>
	<div class="top">
	</br></br>
	<h2>An error has occured, you will be returned to the home page..</h2>
	<p>If you are not automatically redirected, please click<a href="./welcome">here.</a></p>
	</div>
		</center>
	
</div>	
</body>

</html>