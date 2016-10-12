<?php
/*
	Mark points on a route-sketch for a lead climbing competition

	Copyright Roelofs Coaching
*/

defined('_JEXEC') or die;

// if we're not in article view
if (!(JRequest::getVar('option')==='com_content' && JRequest::getVar('view')==='article')) {return;}

define( '_ROUTESCHETS', 1 );

include ('readWriteDatabase.php');

?>

<script>
jQuery(function ($) {

<?php include ('setupPicture.php'); ?>

<?php include ('saveAndClearButtons.php'); ?>

<?php include ('makeNewPoints.php'); ?>

	// draw the points
	function drawPointList(){
		// check orientation
		if (ourPicture.width()/ourPicture.height() > $(window).width()/$(window).height())
			ourPicture.removeClass('vertical').addClass('horizontal')
		else
			ourPicture.removeClass('horizontal').addClass('vertical')
		// clear old
		$('.point').remove();
		if (pointList){
			// paint the points
			for (var index = 0; index < pointList.length; ++index) {
				drawX = Math.round(ourPicture.offset().left + (pointList[index][0] * ourPicture.width()));
				drawY = Math.round(ourPicture.offset().top  + (pointList[index][1] * ourPicture.height()));
				$('<div class="point" style="left :' + drawX + 'px; top: ' + drawY + 'px; position: absolute;"><a class="clickPoint" href="#">' +
					(index + 1) +
				'</a></div>').prependTo('body').children().first().click(function(event){
<?php if ($canEdit) { ?>
					// make menu
					// remove if clicked again
					if ($('#pointMenu').length){
						$('#pointMenu').remove();
					}
					else {
						var origHeight= $(window).height(),
						    origWidth = $(window).width();
						$(this).parent().append('<ul id="pointMenu">' +
							'<li><a href="#" id="up"  >&#x2b06;</a></li>' +
							'<li><a href="#" id="del" >&#x274c;</a></li>' +
							'<li><a href="#" id="down">&#x2b07;</a></li></ul>');
						// make sure it's on screen
						if (document.getElementById('pointMenu').getBoundingClientRect().right > origWidth)
							$('#pointMenu').addClass('moreLeft');
						if (document.getElementById('pointMenu').getBoundingClientRect().bottom > origHeight)
							$('#pointMenu').addClass('moreUp');
						// remove if clicked again
						$('body').one('click', function(event){
							$('#pointMenu').remove();
							return false;
						});
						// implement functionality
						$('#del').click(function(event){
							var number= parseInt($(this).parents('.point').children().html()) - 1;
							pointList.splice(number, 1);
							drawPointList();
							return false;
						});
						$('#up').click(function(event){
							var number= parseInt($(this).parents('.point').children().html()) - 1;
							if (number < pointList.length) {
								var point= pointList[number];
								pointList.splice(number, 1);
								pointList.splice(number+1, 0, point);
								drawPointList();
							}
							return false;
						});
						$('#down').click(function(event){
							var number= parseInt($(this).parents('.point').children().html()) - 1;
							if (number > 0) {
								var point= pointList[number];
								pointList.splice(number, 1);
								pointList.splice(number-1, 0, point);
								drawPointList();
							}
							return false;
						});
					}
<?php } ?>
					return false;
				});
			}
		}
	}

});
</script>
