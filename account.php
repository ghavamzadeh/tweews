<?php include 'header.php';?>

<div id="content">
<h1>Account</h1>
<?php
	//display user's information
	echo '<h2>My Twitter account information</h2>';
	echo '<p>';
	echo '<b>My name</b>: '.$user_data['name'].'<br>';
	echo '<b>My profile URL</b>: <a href="'.$user_data['profile_url'].'" target="_blank">'.$user_data['profile_url'].'</a><br>';
	echo '<b>My Twitter id</b>: '.$user_data['id_str'].'<br><br>';
	echo '<b>My Access token</b>:<br /> <input type="text" value="'.$user_data['token'].'" style="width:380px;"><br>';
	echo '<b>My Access token secret</b>:<br /> <input type="text" value="'.$user_data['token_secret'].'" style="width:380px;"><br>';
	echo '</p>';
	
	//extended information
	echo '<h2>My Twitter extended information</h2>';
	echo '<p>';
	echo '<b>Number of status</b>: '.$user_data['statuses_count'].'<br>';
	echo '<b>Number of friends</b>: '.$user_data['friends_count'].'<br>';
	echo '<b>Number of followers</b>: '.$user_data['followers_count'].'<br>';
	echo '<b>My last status is</b>: '.$user_data['status']['text'].'<br>';
	echo '<b>My last update time is</b>: '.$user_data['status']['created_at'].'<br>';
	echo '<b>My timezone is</b>: '.$user_data['time_zone'].'<br>';
	if($description!='') echo '<b>My profile description is</b>: '.$user_data['description'].'<br>';
	echo '</p>';
	
	//Friends
	$users = $t1->getFriendsList(array('user_id'=>$user_data['id_str'], 'cursor'=>'-1'));
	$users = $users['users'];
	echo '<h2>My Twitter friends</h2>';
	for($i=0; $i<count($users); $i++) {
		$profile_url = 'http://www.twitter.com/'.$users[$i]['screen_name'];
		echo '<a href="'.$profile_url.'" title="'.$users[$i]['screen_name'].'" target="_blank">';
		echo '<img src="'.$users[$i]['profile_image_url'].'" style="width:36px; margin:5px;">';
		echo '</a>';
	}
	echo '<br><br>';
	
	//Followers
	$users = $t1->getFollowersList(array('user_id'=>$user_data['id_str'], 'cursor'=>'-1'));
	$users = $users['users'];
	echo '<h2>My Twitter followers</h2>';
	for($i=0; $i<count($users); $i++) {
		$profile_url = 'http://www.twitter.com/'.$users[$i]['screen_name'];
		echo '<a href="'.$profile_url.'" title="'.$users[$i]['screen_name'].'" target="_blank">';
		echo '<img src="'.$users[$i]['profile_image_url'].'" style="width:36px; margin:5px;">';
		echo '</a>';
	}
	echo '<br><br>';
	
?>
</div>

<?php include 'footer.php'; ?>