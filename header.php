<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Dinero</title>
<meta charset="UTF-8" />

<!-- Include CSS files -->
<link rel="stylesheet" href="include/css/tema.css" type="text/css">

<!-- Include JS files -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="charCount.js"></script>
<script type="text/javascript">
	$(document).ready(function(){	
		//default usage
		$("#message1").charCount();
		//custom usage
		$("#status").charCount({
			allowed: 140,		
			warning: 20,
			counterText: ''	
		});
	});
</script>

	<script>
	$(document).ready(function() {
	$('#show').click(function(){
	   $('#statusbox').slideToggle("slow") 
		})
	});
	</script>

</head>

<body>
<?php include('include/webzone.php'); ?>
<?php include 'sidebar.php'; ?>
<header>
<div class="header-content">
<div class="loginb">

<?php
$t1 = new Twt_box();
$user_data = $t1->getUserData();

if($t1->is_connected()==true) {
	//logout
	echo '<ul>';
	echo '<li class="user">';
	echo ''.$user_data['name'].' </li>';
	echo '<li><a class="btnb" id="show" href="#">Write a status</a></li>';
	echo '<li><a class="btnb" href="account.php">Account</a></li>';
	echo '<li><a class="btnb" href="./account/twt_logout.php">Logout</a></li>';
	echo '</ul>';
}

else {
	echo '<ul>';
	echo '<li><a class="btnb" href="./account/twt_connect.php">Login with Twitter</a></li>';
	echo '</ul>';
}

?>

</div>
</div>
</header>


<div id="wrap">
<div id="statusbox">
<h2>Write a status</h2>
<?php

	//update status
	echo '<form method="get" action="./account/twt_update_status.php">';
	echo '<textarea id="status" name="status"></textarea><br />';
	echo '<input type="submit" value="Update status" class="btn">';
	echo '</form>';
?>

</div>