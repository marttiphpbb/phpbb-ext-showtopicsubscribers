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

	'ACP_MARTTIPHPBB_SHOWSUBSCRIBERS'			=> 'Show subscribers',
	'ACP_MARTTIPHPBB_SHOWSUBSCRIBERS_SETTINGS'	=> 'Settings',

	'ACL_U_MARTTIPHPBB_SHOWSUBSCRIBERS_VIEW'	=> 'Can view who is subscribed to forums and topics',

]);
