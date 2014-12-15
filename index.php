<?php include 'header.php';?>
<div id="content">

<div id="content-top">
<div class="ctop-c">
<h1>Politweets</h1>
</div>
</div>

<div id="content-content">

<?php

		/* BOX WRAPPER #1*/
		echo '<div class="ctweet">';

		/*PROFILE IMAGE*/
		echo '<div class="profileimage">';		
		echo '</div>';
		
		/*DIV FOR BOX*/
        echo '<div class="ctheader">';
		
		echo '<a class="ttitel" href="http://twitter.com/';
        echo 'NAMN';
		echo '">';
        echo 'NAMN';
		echo '</a>';
		
		echo '<div class="datum">';
		echo 'DATUM';
		
		echo '</div></div>';
		
        echo '<div class="tcontent">';
        echo '<p>Proin id feugiat orci, ut scelerisque magna. Vestibulum rutrum pretium quam eu laoreet.</p>';
        echo '</div>';

		/* BOX WRAPPER END #1 */
		echo '</div>';
?>

</div>

</div>

<?php include 'footer.php'; ?>