
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
$(window).scroll(function()
{
    if($(window).scrollTop() == $(document).height() - $(window).height())
    {
        $('div#loadmoreajaxloader').show();
        $.ajax({
        url: "loadmore.php",
        success: function(html)
        {
            if(html)
            {
                $("#content-content").append(html);
                $('div#loadmoreajaxloader').hide();
            }else
            {
                $('div#loadmoreajaxloader').html('<center>No more posts to show.</center>');
            }
        }
        });
    }
});
</script>


<?php include 'script.php'; ?>

</body>
</html>