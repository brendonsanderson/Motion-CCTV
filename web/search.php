<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <title>Muddy Rankings</title>
	<link rel="stylesheet" href="./files/index.css">
</head>

			<div class="project-row header">
		<div class="desc">
			<div class="name">
				<span class="meta"></span>
				<p><a href="./"></a></p>
			</div>
			<div class="year">
				<span class="meta">Admin</span>
				<p><a href="./addgame">Add Game</a></p>
			</div>
				</div>
				</div>
<body>
<div id="content-wrapper">
</br>
<div class="col1">

<?php
include "dbConfig.php";
mysql_select_db('maindb');
$query = "SELECT * FROM player";
$result = mysql_query($query);
echo"<table>";
echo"<tr><td><b>Player</b></td><td><b>Elo</b></td><td><b>Variation</b></td><td><b>Wins</b></td><td><b>Losses</td></b><td><b>Ratio</td></b><tr>";
while($row = mysql_fetch_array($result)) {
	echo"<tr><td>{$row['player']}</td><td>{$row['elo']}</td><td>{$row['variation']}</td><td>{$row['win']}</td><td>{$row['loss']}</td><td>{$row['ratio']}</td></tr>\n";
}
echo "</table>";
mysql_close();
?>

</div>
</div>
</body>
</html>
