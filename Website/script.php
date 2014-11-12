	<script>
		$(document).ready(function() {
			
			// Animate the scroll to top
			$('.go-top').click(function(event) {
				event.preventDefault();
				
				$('html, body').animate({scrollTop: 0}, 300);
			})
		});
	</script>
	
	
	<!-- This script make sure that the sidebar and content are the same height. -->
	<script>
	var sidebar = $('#sidebar');
	var content = $('#content');

	if (content.height() > sidebar.height() )
		sidebar.css('height', content.height());
	else
		sidebar.css('height', sidebar.height());
	</script>
	
	<script>
	$(function(){
    $('header').data('size','big');
	});

	$(window).scroll(function(){
		if($(document).scrollTop() > 0)
		{
			if($('header').data('size') == 'big')
			{
				$('header').data('size','small');
				$('header').stop().animate({
					height:'56px',
					opacity:'0.90'
				},300);
			}
		}
		else
		{
			if($('header').data('size') == 'small')
			{
				$('header').data('size','big');
				$('header').stop().animate({
					height:'56px',
					opacity:'1'
					
				},300);
			}  
		}
	});
	</script>