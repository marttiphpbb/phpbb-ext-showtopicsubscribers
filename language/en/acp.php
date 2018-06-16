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

	'ACP_MARTTIPHPBB_SHOWTOPICSUBSCRIBERS_SETTINGS_SAVED'	=> 'The settings have been saved successfully!',
	'ACP_MARTTIPHPBB_SHOWTOPICSUBSCRIBERS_TRESHOLD'			=> 'Treshold number',
	'ACP_MARTTIPHPBB_SHOWTOPICSUBSCRIBERS_TRESHOLD_EXPLAIN'	=>
		'Above this number of topic subscribers the names of the users are not shown anymore.',

]);
