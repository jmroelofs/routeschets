<?php
/*
	Mark points on a route-sketch for a lead climbing competition

	Copyright Roelofs Coaching
*/

defined('_JEXEC') or die;

// if we're not in article view
if (!(JRequest::getVar('option')==='com_content' && JRequest::getVar('view')==='article')) {return;}

defined('_ROUTESCHETS') or die;


// get article id; our info is linked to the article
$articleId = JRequest::getInt('id');
// get owner id of article
$thisArticle = JTable::getInstance('content');
$thisArticle->load(JRequest::getInt('id'));
$ownerId = $thisArticle->get('created_by');

// get a db connection.
$db = JFactory::getDbo();

// check permissions
$user = JFactory::getUser();
if ($user->authorise('core.edit', 'com_content')){
	$canEdit = true;
} else
if ($user->authorise('core.edit.own', 'com_content')){
	$canEdit = ($user->id === $ownerId);
	} else {
	$canEdit = false;
}

$pointList = JRequest::getVar('pointlist');
if (!empty($pointList)) {

	if (!$canEdit) {
		header('HTTP/1.0 403 Forbidden');
		exit(1);
	}
	// write pointlist to database
	$query = $db->getQuery(true);
	$fields = array(
	$db->quotename('profile_value') . ' = ' . $db->quote($pointList)
	);
	$conditions = array(
	$db->quoteName('user_id') . ' = ' . $ownerId,
	$db->quoteName('profile_key') . ' = ' . $db->quote($articleId)
	);
	$query
	->update($db->quoteName('#__user_profiles'))
	->set($fields)
	->where($conditions);
	$db->setQuery($query);
	if($db->query()) {
		exit(0);
	}
	else {
		header('HTTP/1.0 404 Not Found');
		exit(1);
	}
}
else {

	// read pointlist
	$query = $db->getQuery(true);
	$query
	->select($db->quoteName('profile_value'))
	->from($db->quoteName('#__user_profiles'))
	->where($db->quoteName('profile_key') . ' = '. $db->quote($articleId));
	$db->setQuery($query);
	$pointList = $db->loadResult();

	// if there's no pointlist yet, make one
	if (!isset($pointList)){
		$query = $db->getQuery(true);
		$columns = array('user_id', 'profile_key', 'profile_value');
		$values = array($ownerId, $db->quote($articleId), $db->quote(''));
		$query
		->insert($db->quoteName('#__user_profiles'))
		->columns($db->quoteName($columns))
		->values(implode(',', $values));
		$db->setQuery($query);
		$db->execute();
	}
}
