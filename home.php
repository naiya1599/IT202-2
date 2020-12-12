<?php
session_start();
?>
<ul>
	<li><a href="home.php">Home</a></li>
	<li><a href="login.php">Login</a></li>
	<li><a href="register.php">Register</a></li>
</ul>
<?php
	$email = "";
	if(isset($_SESSION["user"]) && isset($_SESSION["user"]["email"])){
		$email = $_SESSION["user"]["email"];
	}
	
?>
<p>Welcome, <?php echo $email;?></p>

