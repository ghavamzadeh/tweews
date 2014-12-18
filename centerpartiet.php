<?php include 'header.php';?>
<div id="content">
	<div id="content-top">
		<div class="ctop-c">
		<div class="c c2" id="partisymbol">
		
		</div>
		
		<h1>Centerpartiet</h1>
		<input class="info-knapp" type="button" id="myButton" value="Fakta om partiet"/>
		</div>
	</div>

<div id="parti-info">
	<div class="parti-info-content">

	<div class="col-3-div">
	<div>Section 1</div>
	<div>Section 2</div>
	<div>Section 3</div>
	<div>Section 4</div>
	<div>Section 5</div>
	<div>Section 6</div>
	<div>Section 7</div>
	<div>Section 8</div>
	<div>Section 9</div>
	<div>Section 10</div>
	<div>Section 11</div>
	<div>Section 12</div>
	</div>
	
	</div>
</div>

<div id="content-content">


<?php
                $myBucket = $client->bucket('centerpartiet');
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
                echo '</div>';

                /* BOX WRAPPER END #1 */
                echo '</div>';
}
?>

</div>

</div>

<?php include 'footer.php'; ?>