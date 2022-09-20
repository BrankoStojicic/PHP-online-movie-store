<?php 
session_start();
if(!isset($_SESSION['status'])||$_SESSION['status']!=3){
	header("location: index.html");
} 
require "../config.php";
$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DB);
$selected_id = -1;
$selected_name = "";
$selected_description = "";

if(isset($_GET['cid'])){
	$q = mysqli_query($conn,"select * from categories where id = {$_GET['cid']}");
	$rw = mysqli_fetch_object($q);
	if($rw){
		$selected_id = $rw->id;
		$selected_name = $rw->name;
		$selected_description = $rw->description;
	}
} 
if(isset($_POST['btn_insert'])){
	$selected_name = $_POST['tb_name'];
	$selected_description = $_POST['tb_description'];
	mysqli_query($conn,"insert into categories values (null,'{$selected_name}','{$selected_description}')");
	$selected_id = mysqli_insert_id($conn);
}
if(isset($_POST['btn_update'])){
	$selected_name = $_POST['tb_name'];
	$selected_description = $_POST['tb_description'];
	$selected_id = $_POST['selCategory'];
	mysqli_query($conn,"update categories set name='{$selected_name}',description='{$selected_description}' where id = {$selected_id}");
}

?>
<form method="post" action="">
<?php
$q = mysqli_query($conn,"select * from categories");
?>
<select onchange="window.location='?cid='+this.value" name="selCategory">
<option value="-1">Select category</option>
<?php
while($rw=mysqli_fetch_object($q)){ 
	echo "<option " . ($selected_id==$rw->id?"selected":"") . " value='{$rw->id}'>{$rw->name}</option>";		
}
?>
</select>
<br />
Name:<br />
<input type="text" name="tb_name" value="<?php echo $selected_name; ?>" />
<br />
Description: <br />
<input type="text" name="tb_description" value="<?php echo $selected_description; ?>" />
<br /> <br /> 
<input type="submit" name="btn_insert" value="Add new" />
<input type="submit" name="btn_update" value="Update" />
<input type="submit" name="btn_delete" value="Delete" />
</form>