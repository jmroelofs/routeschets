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
	// implement making new points
	ourPicture.click(function (e) {
		if (!$('#pointMenu').length){
			var relX= (e.pageX - $(this).offset().left)/$(this).width(),
				relY= (e.pageY - $(this).offset().top)/$(this).height();
			if (!pointList)
				pointList= [[relX, relY]];
			else {
				for (var i= 0; i < pointList.length && relY < pointList[i][1]; i++);
				pointList.splice(i, 0, [relX, relY]);
			}
			drawPointList();
		}
	});
<?php } ?>
