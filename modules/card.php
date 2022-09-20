<?php
session_start();
if(!isset($_SESSION['card'])){
		$_SESSION['card'] = array();
}
if(isset($_POST['mid'])&&isset($_POST['quantity'])){ 
	if(isset($_SESSION['card'][$_POST['mid']])){
		$_SESSION['card'][$_POST['mid']]+=$_POST['quantity'];
	} else {
		$_SESSION['card'][$_POST['mid']]=$_POST['quantity'];
	} 
	if($_SESSION['card'][$_POST['mid']]<=0){
		unset($_SESSION['card'][$_POST['mid']]);
	}
}
if(empty($_SESSION['card'])){
	echo "card is empty";
	return;
}
$movie_ids = array_keys($_SESSION['card']);
$movie_ids_string = implode(",",$movie_ids);
 
$q = mysqli_query($conn,"select * from movies where id in ({$movie_ids_string})");
while($rw=mysqli_fetch_object($q)){ 
	for($i=0; $i<4; $i++) 
?>
<div class="<?php echo (($i+1)%2==0)?"rightbox":"leftbox"; ?>">
          <h3><?php echo $rw->title; ?></h3>
          <img src="images/<?php echo $rw->image; ?>" width="93" height="95" alt="photo 1" class="left" />
          <p><b>Price:</b> <b>$<?php echo $rw->price; ?></b> &amp; eligible for FREE Super Saver Shipping on orders over <b>$195</b>.</p>
          <?php if($rw->supersaver){ ?>
		  <p><b>Availability:</b> Usually ships within 24 hours</p>
		  <?php } ?>
		  Quantity: <?php echo $_SESSION['card'][$rw->id]; ?>
          <p class="readmore"><a href="?page=5&mid=<?php echo $rw->id; ?>">BUY <b>NOW</b></a></p>
          <div class="clear"></div>
        </div> 
<?php
}
?>
<div class="clear"></div> 
<a href="?page=6" style="font-size:1.2em;">CHECKOUT</a>