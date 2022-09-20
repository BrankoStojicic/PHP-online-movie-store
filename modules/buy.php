<?php
$id = isset($_GET['mid'])&&is_numeric($_GET['mid'])?$_GET['mid']:0;
$q = mysqli_query($conn,"select * from movies where id = {$id}");
$rw=mysqli_fetch_object($q);
if(!$rw){
	echo "Movie does not exist";
} else {
?>
<div class="leftbox">
          <h3><?php echo $rw->title; ?></h3>
          <img src="images/<?php echo $rw->image; ?>" width="93" height="95" alt="photo 1" class="left" />
          <p><b>Price:</b> <b>$<?php echo $rw->price; ?></b> &amp; eligible for FREE Super Saver Shipping on orders over <b>$195</b>.</p>
          <?php if($rw->supersaver){ ?>
		  <p><b>Availability:</b> Usually ships within 24 hours</p>
		  <?php } ?> 
          <div class="clear"></div>
			<form action="?page=3" method="post"> 
			<input type="hidden" name="mid" value="<?php echo $rw->id; ?>" />
			<input type="number" name="quantity" value="1" /> <input type="submit" value="add" />
			</form>
        </div>  

<div class="clear"></div>
<?php
}