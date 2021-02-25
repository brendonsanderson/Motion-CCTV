<?php
  session_start();
  session_destroy();
  header("Location: ./index");
?>
<html>
    <title>Logout</title>
	<link rel="stylesheet" href="./files/index.css?version5.5">
</head>			
<body>
	<center>
<div id="content-wrapper">
</br>
	<div class="top">
	</br></br>
	<h2>You have successfully logged out.</h2>
	<p>If you are not automatically redirected, please click<a href="./index">here.</a></p>
	</div>
		</center>
	
</div>	
</body>

</html>