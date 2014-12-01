<?php include 'header.php';?>

<div id="content">
<h1>Update status</h1>
<?php

	//update status
	echo '<form method="get" action="./account/twt_update_status.php">';
	echo '<p><textarea id="status" name="status" style="width:460px; height:80px;"></textarea><br>';
	echo '<p><input type="submit" value="Update status" class="btn"></p>';
	echo '</p></form>';
	
?>
</div>

<?php include 'footer.php'; ?>