<?php

/**
* phpBB Extension - marttiphpbb showtopicsubscribers
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

	'MARTTIPHPBB_SHOWTOPICSUBSCRIBERS_SUBSCRIBED' => [
		0 => 'No users subscribed to this topic',
		1 => '1 user subscribed to this topic',
		2 => '%1$s users subscribed to this topic',
	],
]);
