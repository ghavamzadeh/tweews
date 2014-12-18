<?php include 'header.php';?>
<div id="content">

<div id="content-top">
<div class="ctop-c">
<h1>Politweets</h1>
</div>
</div>

<div id="content-content">

<?php
	
                $myBucket = $client->bucket('index');
                $keys = $myBucket->getKeys();

                for($x=0; $x<=30; $x++) {
                $fetched = $myBucket->get($keys[$x]);
                $data = $fetched->getData();
                $user = $data['user'];
                date_default_timezone_set('UTC');
                $date = new DateTime( $data->created_at);


                /* BOX WRAPPER #1*/
                echo '<div class="ctweet">';

                /*PROFILE IMAGE*/
                echo '<img class="profileimage" src="';
				echo $user['profile_image_url']. "\n";
                echo '"/>';

                /*DIV FOR BOX*/
                echo '<div class="ctheader">';

                echo '<a class="ttitel" href="http://twitter.com/';
                                 echo $user['screen_name']. "\n";
                echo '">';
				echo $user['screen_name']. "\n";
                echo '</a>';

                echo '<div class="datum">';
				echo $date->format( 'h:i l M jS' );

                echo '</div></div>';

                echo '<div class="tcontent"><p>';
				echo $data['text']. "<br>";
                echo '</p></div>';

                /* BOX WRAPPER END #1 */
                echo '</div>';
}
?>

</div>

</div>

<?php include 'footer.php'; ?>