<?php
include('tmhOAuth.php');
include('tmhUtilities.php');

class Twt_box
{
	var $tmhOAuth;
	
	function Twt_box() {
		$this->tmhOAuth = new tmhOAuth(array(
		  'consumer_key'    => $GLOBALS['twt_consumer_key'],
		  'consumer_secret' => $GLOBALS['twt_consumer_secret'],
		));
	}
	
	//Check if the user is connected
	function is_connected() {
		if(isset($_SESSION['access_token']) && $_SESSION['access_token']!='') {
			return true;
		}
		else {
			return false;
		}
	}
	
	//Friends list
	function getFriendsList($criteria=array()) {
		$user_id = $criteria['user_id'];
		$cursor = $criteria['cursor'];
		//if($user_id=='') $user_id = $_SESSION['access_token']['user_id'];
		
		$data = $this->getDataFromAPI(array('connection'=>'friends/list', 'params'=>array('user_id'=>$user_id, 'cursor'=>$cursor)));
		return $data;
	}
	
	//Followers list
	function getFollowersList($criteria=array()) {
		$user_id = $criteria['user_id'];
		$cursor = $criteria['cursor'];
		//if($user_id=='') $user_id = $_SESSION['access_token']['user_id'];
		
		$data = $this->getDataFromAPI(array('connection'=>'followers/list', 'params'=>array('user_id'=>$user_id, 'cursor'=>$cursor)));
		return $data;
	}
	
	//Publish a Tweet
	function publishTweet($criteria=array()) {
		$status = $criteria['status'];
		
		$tmhOAuth = new tmhOAuth(array(
		  'consumer_key'    => $GLOBALS['twt_consumer_key'],
		  'consumer_secret' => $GLOBALS['twt_consumer_secret'],
		  'user_token'      => $_SESSION['access_token']['oauth_token'],
		  'user_secret'     => $_SESSION['access_token']['oauth_token_secret'],
		));
		
		$code = $tmhOAuth->request('POST', $tmhOAuth->url('1.1/statuses/update'), array(
		  'status' => $status
		));
		
		$response = json_decode($tmhOAuth->response['response']);
		return $response;
	}
	
	//Get a user data
	function getUserData($criteria=array()) {
		$user_id = $criteria['user_id'];
		
		if($user_id=='') {
			if($_SESSION['twt_box']['user_data']['id_str']=='') {
				$user_id = $_SESSION['access_token']['user_id'];
				$data = $this->getDataFromAPI(array('connection'=>'users/show', 'params'=>array('user_id'=>$user_id)));
			}
			else {
				$data = $_SESSION['twt_box']['user_data'];
			}
		}
		else {
			$data = $this->getDataFromAPI(array('connection'=>'users/show', 'params'=>array('user_id'=>$user_id)));
		}
		
		return $data;
	}
	
	function getDataFromAPI($criteria=array()) {
		$connection = $criteria['connection'];
		$params = $criteria['params'];
		
		$tmhOAuth = new tmhOAuth(array(
		  'consumer_key'    => $GLOBALS['twt_consumer_key'],
		  'consumer_secret' => $GLOBALS['twt_consumer_secret'],
		  'user_token'      => $_SESSION['access_token']['oauth_token'],
		  'user_secret'     => $_SESSION['access_token']['oauth_token_secret'],
		));
		
		$code = $tmhOAuth->request('GET', $tmhOAuth->url('1.1/'.$connection.'.json'), $params);
		$data = $tmhOAuth->response['response'];
		$data = json_decode($data, true);
		
		return $data;
	}
	
	/*
	function getDataFromUrl($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to make it support SSL calls on some servers
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	*/
	
	//############################
	//START Authentication process
	function connect_process() {		
		if (isset($_REQUEST['oauth_verifier'])) $this->access_token($this->tmhOAuth);
		
		if(isset($_SESSION['access_token']) && $_SESSION['access_token']!='') {
			// nothing
		}
		else {
			$this->request_token($this->tmhOAuth);
		}
	}
		
	function outputError($tmhOAuth) {
	  	echo 'There was an error: ' . $tmhOAuth->response['response'] . PHP_EOL;
	}
	
	// Step 1: Request a temporary token
	function request_token($tmhOAuth) {
	  	$code = $tmhOAuth->request(
	    	'POST',
	    	$tmhOAuth->url('oauth/request_token', ''),
	    	array(
	      'oauth_callback' => tmhUtilities::php_self()
	      )
	    );
	  
	    if ($code == 200) {
	    	$_SESSION['oauth'] = $tmhOAuth->extract_params($tmhOAuth->response['response']);
	    	$this->authorize($tmhOAuth);
	    }
	    else {
	    	$this->outputError($tmhOAuth);
	    }
	}
	
	// Step 2: Direct the user to the authorize web page
	function authorize($tmhOAuth) {
	  	$authurl = $tmhOAuth->url("oauth/authenticate", '') .  "?oauth_token={$_SESSION['oauth']['oauth_token']}";
	  	header("Location: {$authurl}");
	
	  	// in case the redirect doesn't fire
	  	echo '<p>To complete the OAuth flow please visit URL: <a href="'. $authurl . '">' . $authurl . '</a></p>';
	}
	
	// Step 3: This is the code that runs when Twitter redirects the user to the callback. Exchange the temporary token for a permanent access token
	function access_token($tmhOAuth) {
	  	$tmhOAuth->config['user_token']  = $_SESSION['oauth']['oauth_token'];
	  	$tmhOAuth->config['user_secret'] = $_SESSION['oauth']['oauth_token_secret'];
	
	  	$code = $tmhOAuth->request(
	    	'POST',
	    	$tmhOAuth->url('oauth/access_token', ''),
	    	array(
	    	'oauth_verifier' => $_REQUEST['oauth_verifier']
	    	)
	    );
	
	    if ($code == 200) {
	    	$_SESSION['access_token'] = $tmhOAuth->extract_params($tmhOAuth->response['response']);
	    	unset($_SESSION['oauth']);
	    	header('Location: ' . tmhUtilities::php_self());
	    }
	    else {
			$this->outputError($tmhOAuth);
		}
	}
}

?>