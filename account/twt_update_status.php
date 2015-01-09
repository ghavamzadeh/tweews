<?php
include_once('../include/webzone.php');

$status = $_GET['status'];

$t1 = new Twt_box();
$response = $t1->publishTweet(array('status'=>$status));

if($response->errors[0]->message!='') {
	echo 'Error publishing your status: ';
	echo $response->errors[0]->message;
	echo '<br><a href="../index.php">Back</a>';
}
else {
	$status_id = $response->id_str;
	$screen_name = $response->user->screen_name;
	echo 'Your <a href="http://twitter.com/'.$screen_name.'/status/'.$status_id.'" target="_blank">status</a> has been published.';
	echo '<br><a href="../index.php">Back</a>';
}

?>