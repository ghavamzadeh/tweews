<?php
include_once('../include/webzone.php');

$t1 = new Twt_box();

if($t1->is_connected()===true) {
	$user_data = $t1->getUserData();
	$user_data['profile_url'] = 'http://www.twitter.com/'.$_SESSION['access_token']['screen_name'];
	$user_data['token'] = $_SESSION['access_token']['oauth_token'];
	$user_data['token_secret'] = $_SESSION['access_token']['oauth_token_secret'];
	$_SESSION['twt_box']['user_data'] = $user_data;
	header('Location: ../index.php');
}
else {
	$t1->connect_process();
}

?>