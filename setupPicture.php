<?php
/*
	Mark points on a route-sketch for a lead climbing competition

	Copyright Roelofs Coaching
*/

defined('_JEXEC') or die;

// if we're not in article view
if (!(JRequest::getVar('option')==='com_content' && JRequest::getVar('view')==='article')) {return;}

defined('_ROUTESCHETS') or die;

?>

	// reading points
	var pointList= $.parseJSON('<?php echo $pointList ?>');

	// setup picture
	var ourPicture= $('.item-page img').last().clone().addClass('bigpicture');
	$('body').children().remove();
	$('body').prepend(ourPicture);

	// get the css and draw the pointlist
	$.get("<?php echo rtrim(dirname(filter_input(INPUT_SERVER, 'SCRIPT_NAME', FILTER_SANITIZE_STRING)), '/') .'/'. basename(dirname(__FILE__)); ?>/pointmenu.css", function(css){
		$('<style type="text/css"></style>').html(css).appendTo("head");
		// for slow loading stuff (iPad) we make sure there's a redraw when loaded late
		ourPicture.on('load', drawPointList);
		drawPointList();
	});

	// force redraw when resizing
	$(window).resize(drawPointList);
