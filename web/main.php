<?php 
session_start();
if (isset($_SESSION['logged_in'])) {
} else {
	header("Location: ./login");
	}
?>
<!DOCTYPE html>

<html>
    <title>Home</title>
	<link rel="stylesheet" href="./files/index.css?version5.5">
	</head>		

			<div class="project-row header">
		<div class="desc">
			<div class="name">
				<span class="meta">Navigation</span>
				<p><a href="./index">Home</a></p>
			</div>
			<div class="year">
				<span class="meta">User</span>
				<p><a href="./logout">Logout</a></p>
			</div>
				</div>
				</div>	
<body>
    <center>
<div id="content-wrapper">
</br>
	<div class="top">
	<?
	echo '<h2>Welcome Back, '.$_SESSION['username'].'</h2>';
	?>
	</div>

	<div class="col1">
	<h1>Recent Activity</h1>
	<?
        $threshhold = 4;
	$dirname = "files/images/";
	$images = glob($dirname."*.jpg");
        foreach($images as $image)
        {
                $threshhold--;

                if($threshhold > -1) // arrays start at 0
		    echo '<img src="'.$image.'" />';
                else
                    break;
        }
        ?>
	<h1><a href="./images">View All >>></a></h1>
	</div>
	
	<form action="process.php" method="POST">
		<div class="col4">
		<h1>Event Search</h1></br>
	<div class="dropdown">
		<h2>Event Type:</h2>
		<select id="event" name="event">
			<option>Select:</option>
			<option value="Motion">Motion</option>
			<option value="Face">Face</option>
		</select>
	</div></br>
	<div class="dropdown">
		<h2>From Camera:</h2>
		<select id="camera" name="camera">
			<option>Select:</option>
			<option value="1">1</option>
			<option value="2">2</option>
		</select>
	</div></br>

	<h2>On Date</h2>
	<input type="text" id="date" name="date" placeholder="DD/MM/YYYY" required pattern="(?:30))|(?:(?:0[13578]|1[02])-31))/(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])/(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])" title="Enter a date in this format DD/MM/YYYY"/>
	<hr style="height:160pt; visibility:hidden;" />
	<button type="submit">Search >>></button>
	</form>
	</div>
    </center>
</div>	
</body>

</html>