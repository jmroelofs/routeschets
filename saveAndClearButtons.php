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

<?php if ($canEdit) { ?>
	// saving
	function save(){
		$.post( '', {'pointlist': JSON.stringify(pointList)})
		.done(function(){alert( 'Point list saved' );})
	}

	$('body').prepend('<div id="saveButton" style="position:fixed;"><a href="#">Save</a></div>');
	$('#saveButton').click(function(event){
		event.preventDefault();
		save();
	});
	// end of saving


	// clearing
	function clear(){
		pointList = null;
		drawPointList();
	}

	$('body').prepend('<div id="clearButton" style="position:fixed;"><a href="#">Clear</a></div>');
	$('#clearButton').click(function(event){
		event.preventDefault();
		clear();
	});
	// end of clearing
<?php } ?>

	$('body').prepend('<div id="homeButton" style="position:fixed;"><a href="/">Home</a></div>');
	$('body').prepend('<div id="loginButton" style="position:fixed;"><a href="index.php?option=com_users&view=login"><?php echo $canEdit ? 'Logout' : 'Login'; ?></a></div>');
