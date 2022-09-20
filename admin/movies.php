<?php 
session_start();
if(!isset($_SESSION['status'])||$_SESSION['status']!=3){
	header("location: index.html");
} 
require "../config.php";
$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DB);
$selected_id = -1;
$selected_title = "";
$selected_price = "";
$selected_image = "";
$selected_availability = 0;
$selected_supersaver = 0;
$selected_category = 0;

if(isset($_GET['mid'])){
	$q = mysqli_query($conn,"select * from movies where id = {$_GET['mid']}");
	$rw = mysqli_fetch_object($q);
	if($rw){
		$selected_id = $rw->id;
		$selected_title = $rw->title;
		$selected_price = $rw->price;
		$selected_image = $rw->image;
		$selected_availability = $rw->availability;
		$selected_supersaver = $rw->supersaver;
		$selected_category = $rw->category;
	}
} 

if(isset($_POST['btn_insert'])){ 
		$selected_title = $_POST['tb_title'];
		$selected_price = $_POST['tb_price'];
		
		if(isset($_FILES['fup_image'])){
			move_uploaded_file($_FILES['fup_image']['tmp_name'],"../images/".$_FILES['fup_image']['name']);
			$selected_image = $_FILES['fup_image']['name'];
		} 
		$selected_availability = isset($_POST['cb_availability']);
		$selected_supersaver = isset($_POST['cb_supersaver']);
		$selected_category = $_POST['sel_category'];
	mysqli_query($conn,"insert into movies values (null,'{$selected_title}',{$selected_price},'{$selected_image}','{$selected_availability}','{$selected_supersaver}',{$selected_category})");
	$selected_id = mysqli_insert_id($conn);
}

?>
<form action="" method="post" enctype="multipart/form-data" >
<select onchange="window.location='?mid='+this.value" name="selMovie">
<option value="-1">Select movie</option>
<?php
$q = mysqli_query($conn,"select * from movies");
?>
<?php
while($rw=mysqli_fetch_object($q)){ 
	echo "<option " . ($selected_id==$rw->id?"selected":"") . " value='{$rw->id}'>{$rw->title}</option>";		
}
?>
</select>
<br />
Title:<br />
<input type="text" name="tb_title" value="<?php echo $selected_title; ?>" />
<br />
Price:<br />
<input type="text" name="tb_price" value="<?php echo $selected_price; ?>" />
<br />
Availability:<br />
<input type="checkbox" name="cb_availability" <?php echo ($selected_availability)?"checked":""; ?> />
<br />
supersaver:<br />
<input type="checkbox" name="cb_supersaver"<?php echo ($selected_supersaver)?"checked":""; ?> />
<br />
Category:<br />
<?php
$q = mysqli_query($conn,"select * from categories");
?>
<select name="sel_category">
<option value="-1">Select category</option>
<?php
while($rw=mysqli_fetch_object($q)){ 
	echo "<option " . ($selected_category==$rw->id?"selected":"") . " value='{$rw->id}'>{$rw->name}</option>";		
}
?>
</select>
<br />
<img src="../images/<?php echo $selected_image; ?>" width="93" height="95" />
<input type="file" name="fup_image" />
<br /><br />
<input type="submit" name="btn_insert" value="Add new" />
<input type="submit" name="btn_update" value="Update" />
<input type="submit" name="btn_delete" value="Delete" />
</form>