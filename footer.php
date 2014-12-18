</div>

<footer>
	<div class="copy">
	<ul>
		<li class="copy-box">&copy; 2014 Dinero</li>
	</ul>
	</div>

	<div class="top"><a href="#" class="go-top">Toppen</a></div>
	
</footer>

<script>
$("#myButton").toggle(function(){
    $("#parti-info").slideDown();
    $(this).val("Dölj fakta");
},function(){
    $("#parti-info").slideUp();
    $(this).val("Fakta om partiet")
})
</script>

<?php include 'script.php'; ?>

</body>
</html>