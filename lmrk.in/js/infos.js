
$(document).ready(function(){
	$('ul.toggle_display').css('display', 'block');
	$('.tab h2').css('display','none');
	
	// Toggle tabs
	$('ul.toggle_display li a').click(function(){
		var target = $(this).attr('href').replace('#', ''); // 'stat_tab_location'
		var divs = target.split('_')[1]; // 'tab'
		$('div.'+divs).css('display', 'none');
		$('div#'+target).css('display', 'block');
		$('ul.stat_'+divs+' li a').removeClass('selected');
		//$(this).addClass('selected').css('outline', 'none').blur();
		$('ul.stat_'+divs+' li a[href="#'+target+'"]').addClass('selected').css('outline', 'none').blur();
		return false;
	});
	
	// Activate main tab
	if (location.hash) {
		$('#tabs ul#headers li a[href="'+location.hash+'"]').click();
	} else {
		$('#tabs ul#headers li a:first').click();
	}
	
	// Activate first line graph
	$('#stats_lines li a:first').click();
	
	// Prettify list
	$('#historical_clicks li:odd').css('background', '#FFE3BB');
	
	// Toggle detail lists
	$('a.details').click(function(){
		var target = $(this).attr('id').replace('more_', 'details_');
		$('#'+target).toggle();
		return false;	
	});
	
	// If an image src is erroneous (404 or anything) replace it with a transparent gif
	$('.fix_images').each(function(i,img) {
		$(img).error(function(){
			$(img).attr('src', 'images/blank.gif');
		});
	});

});
