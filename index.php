<?php include 'header.php';?>
<div id="content">

<div id="content-top">
<div class="ctop-c">
<h1>Politweets</h1>
</div>
</div>

<div id="content-content">

<?php


require_once('src/Basho/Riak/Riak.php');
                require_once('src/Basho/Riak/Bucket.php');
                require_once('src/Basho/Riak/Exception.php');
                require_once('src/Basho/Riak/Link.php');
                require_once('src/Basho/Riak/MapReduce.php');
                require_once('src/Basho/Riak/Object.php');
                require_once('src/Basho/Riak/StringIO.php');
                require_once('src/Basho/Riak/Utils.php');
                require_once('src/Basho/Riak/Link/Phase.php');
                require_once('src/Basho/Riak/MapReduce/Phase.php');

                                $client = new Basho\Riak\Riak('172.31.32.109',10018);
                                $myBucket = $client->bucket('world');
                                $keys = $myBucket->getKeys();

                for($x=0; $x<=sizeof($keys); $x++) {
                $fetched = $myBucket->get($keys[$x]);
                $data = $fetched->getData();
                $user = $data['user'];
                date_default_timezone_set('UTC+8');
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
                echo '</div>';

                /* BOX WRAPPER END #1 */
				echo '<div id="loadmoreajaxloader" style="display:none;"><center>Load more bitch</center></div>';
                echo '</div>';
}
?>

</div>

</div>

<?php include 'footer.php'; ?>