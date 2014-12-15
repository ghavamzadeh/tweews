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

echo '<div class="ctweet">';

        echo '<div class="ctheader"><div class="ct"><a class="ttitel" href="';
        echo $data['screen_name']. "\h";
		echo '">';
        echo $data['description']. "\n";
        echo '</a></div>';

        echo '<div class="datum">';
        echo $data['created_at']."\r\n";
        echo '</div></div>';


        echo '<div class="tcontent"><p>';
        echo $data['text']. "<br>";
        echo '</p></div>';

echo '</div>';
}
?>

</div>

</div>

<?php include 'footer.php'; ?>