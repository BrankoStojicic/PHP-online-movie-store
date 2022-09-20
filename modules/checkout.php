<?php
if(isset($_POST['btnCheckout'])){
	$name = $_POST['tbName'];
	$address = $_POST['tbAddress'];
	session_start();
	if(!isset($_SESSION['card'])||empty($_SESSION['card'])){
		echo "Card is empty";
	} else {
		$cardcontent = json_encode($_SESSION['card']);
		$q = "insert into orders values (null,'{$name}','{$address}','{$cardcontent}')";
		mysqli_query($conn,$q);
		$_SESSION['card']=array();
	}
}
?>
<form action="" method="post">
Name: <input type="text" name="tbName" /><br />
Address: <textarea name="tbAddress" ></textarea><br />
<input type="submit" name="btnCheckout" />
</form>