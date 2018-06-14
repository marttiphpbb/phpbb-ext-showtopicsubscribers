<?php

/**
* phpBB Extension - marttiphpbb showsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [

	'MARTTIPHPBB_SHOWSUBSCRIBERS_SUBSCRIBED_TO_TOPIC'			
		=> 'Subscribed to this topic',
	'MARTTIPHPBB_SHOWSUBSCRIBERS_SUBSCRIBED_TO_FORUM'			
		=> 'Subscribed to this forum',
]);
