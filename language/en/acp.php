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

	'ACP_MARTTIPHPBB_SHOWSUBSCRIBERS_SETTINGS_SAVED'		=> 'The settings have been saved successfully!',
	'ACP_MARTTIPHPBB_SHOWSUBSCRIBERS_AJAX_TRESHOLD'			=> 'Ajax treshold',
	'ACP_MARTTIPHPBB_SHOWSUBSCRIBERS_AJAX_TRESHOLD_EXPLAIN'	=> 'Show the subscribers upon user`s request using ajax when the number is greater then the treshold otherwise serve directly.',

]);
