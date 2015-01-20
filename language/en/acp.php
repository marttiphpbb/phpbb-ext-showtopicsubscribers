<?php

/**
* phpBB Extension - marttiphpbb showsubscribers
* @copyright (c) 2015 marttiphpbb <info@martti.be>
* @license http://opensource.org/licenses/MIT
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

	'ACP_SHOWSUBSCRIBERS_SETTINGS_SAVED'		=> 'The settings have been saved successfully!',
	'ACP_SHOWSUBSCRIBERS_AJAX_TRESHOLD'			=> 'Ajax treshold',
	'ACP_SHOWSUBSCRIBERS_AJAX_TRESHOLD_EXPLAIN'	=> 'Show the subscribers upon user\'s request using ajax when the number is greater then the treshold otherwise serve directly.',

));
