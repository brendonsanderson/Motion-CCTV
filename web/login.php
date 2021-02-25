<?php 
session_start();
include "dbConfig.php";
$msg = "";
$debug_mode = 2;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST["username"];
    $password = $_POST["password"];
	 if ($username == '' || $password == '') {
		 $msg = "Please enter all fields";	
    } else {
        $sql = "SELECT * FROM members WHERE username = '$username' AND password = '$password'";
        $query = mysql_query($sql);

        if ($query === false) {
            echo "Could not successfully run query ($sql) from DB: " . mysql_error();
            exit;
        }
		
        if (mysql_num_rows($query) > 0) {
			$_SESSION['logged_in']=true;
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];
            header('Location: ./main');
            exit;
        } else {
			$msg = "Incorrect username or password";	
		}


    }
}
?>

<!DOCTYPE html>
<html>
    <title>Login</title>
    <link rel="stylesheet" href="./files/index.css?version5.5">
<head>
</head>
<header>
			<div class="project-row header">
		<div class="desc">
			<div class="name">
				<span class="meta">Navigation</span>
				<p><a href="./index">Home</p>
			</div>
			<div class="name">
			</div>
			<div class="team">
				<span class="meta"></span>
				<p></p>
			</div>
			<div class="year">
				<span class="meta"> </span>
				<p> </a></p>
			</div>
				</div>
				</div>	
</header>				

<body>
<div id="content-wrapper">
<div id="wrapper">

</br></br>
<center>
	<form name="frmregister"action="<?= $_SERVER['PHP_SELF'] ?>" method="post" >
<table>
<?
echo"<p>{$msg}</p>";
?>
<tr>
<h2>Login </h2>
</tr>

<tr>
<td>Name </td>
<td><input class="inp-text" name="username" id="username" type="text" size="20" /></td>
</tr>

<tr>
<td>Password </td>
<td><input class="inp-text" name="password" id="password" type="password" size="20" /></td>
</tr>
	<tr>
	<td><input type="submit" name="submit" value="submit" alt="Submit" title="Submit">	</td>			</td>
	</tr>
	
</table>
</form>
</div>	
</div>
</center>
</body>
</html>
