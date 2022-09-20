<?php
session_start();
if(!isset($_SESSION['status'])||$_SESSION['status']!=3){
	header("location: index.html");
}
?>
<a href="categories.php">categories</a>
<a href="movies.php">movies</a>
<a href="logout.php">Logout</a>