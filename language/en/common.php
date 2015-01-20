<?php

/**
* phpBB Extension - marttiphpbb showsubscribers
* @copyright (c) 2015 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(

	'SHOWSUBSCRIBERS_SUBSCRIBERS'			=> 'Subscribers',
	'SHOWSUBSCRIBERS_TOTAL_USERS_FORUM'		=> array(
		0 => 'No user subscribed to this forum',
		1 => '1 user subscribed to this forum',
		2 => '%s users subscribed to this forum',
	),
	'SHOWSUBSCRIBERS_TOTAL_USERS_TOPIC'		=> array(
		0 => 'No user subscribed to this topic',
		1 => '1 user subscribed to this topic',
		2 => '%s users subscribed to this topic',
	),
	'SHOWSUBSCRIBERS_PROFILE_SUBSCRIBED_TO_FORUMS' => array(
		0 => '%1s subscribed to no forums',
		1 => '%1s subscribed to one forum',
		2 => '%1s subscribed to 2%s forums',
	),
	'SHOWSUBSCRIBERS_PROFILE_SUBSCRIBED_TO_TOPICS' => array(
		0 => '%1s subscribed to no topics',
		1 => '%1s subscribed to one topics',
		2 => '%1s subscribed to 2%s topics',
	),
));
