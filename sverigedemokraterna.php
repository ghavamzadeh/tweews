<?php include 'header.php';?>
<div id="content">
	<div id="content-top">
		<div class="ctop-c">
		<div class="sd sd2" id="partisymbol">
		
		</div>
		
		<h1>Sverigedemokraterna</h1>
		<input class="info-knapp" type="button" id="myButton" value="Fakta om partiet"/>
		</div>
	</div>

<div id="parti-info">
	<div class="parti-info-content">
	<div id="profil" class="psd">
	
	</div>
	
	<div class="col-3-div">
		<div class="o"><strong>Partiordförande</strong> Jimmie Åkesson</div>
		<div class="o"><strong>Grundat</strong> 6 februari 1988</div>
		<div class="o"><strong>Antal medlemmar</strong> 15 000 <i>(egen uppgift)</i></div>
		<div class="o"><strong>Politisk ideologi</strong> Nationalkonservatism, Nationalism</div>
		<div class="o"><strong>Politisk position</strong> Center</div>
		<div class="o"><strong>Hemsida</strong> <a target="_blank" href="http://www.sverigedemokraterna.se">www.sverigedemokraterna.se</a></div>
	</div>
	
	</div>
</div>

<div id="content-content">

<?php
                $myBucket = $client->bucket('sd');
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