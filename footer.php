
</div>

<footer>
	<div class="copy">
	<ul>
		<li class="copy-box">&copy; 2014 Dinero</li>
	</ul>
	</div>

	<div class="top"><a href="#" class="go-top">Toppen</a></div>
	
</footer>

<script type="text/javascript">
function yHandler(){

	var wrap = document.getElementById('infinityballs');
	var contentHeight = infinityballs.offsetHeight;
	var yOffset = window.pageYOffset; 
	var y = yOffset + window.innerHeight;
	if(y >= contentHeight){
		// Ajax call to get more dynamic data goes here
		infinityballs.innerHTML += '<div class="newData"></div>';
	}
	var status = document.getElementById('status');
	status.innerHTML = contentHeight+" | "+y;
}
window.onscroll = yHandler;
</script>

<?php include 'script.php'; ?>

</body>
</html>