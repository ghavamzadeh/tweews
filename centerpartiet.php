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
	<div id="profil" class="pc">
	
	</div>
	
	<div class="col-3-div">
	<div class="o"><strong>Partiordförande</strong> Annie Lööf</div>
	<div class="o"><strong>Grundat</strong> 2 mars 1913</div>
	<div class="o"><strong>Antal medlemmar</strong> 28 871 <i>(2014)</i></div>
	<div class="o"><strong>Politisk ideologi</strong> Liberalism, Grön ideologi, Decentralism</div>
	<div class="o"><strong>Politisk position</strong> Center-höger</div>
	<div class="o"><strong>Hemsida</strong> <a target="_blank" href="http://www.centerpartiet.se/">www.centerpartiet.se</a></div>
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