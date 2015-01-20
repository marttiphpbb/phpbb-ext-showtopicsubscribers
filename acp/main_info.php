<?php
/**
* phpBB Extension - marttiphpbb showsubscribers
* @copyright (c) 2015 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showsubscribers\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\marttiphpbb\showsubscribers\acp\main_module',
			'title'		=> 'ACP_SHOWSUBSCRIBERS',
			'modes'		=> array(
				'settings'	=> array(
					'title' => 'ACP_SHOWSUBSCRIBERS_SETTINGS',
					'auth' => 'ext_marttiphpbb/showsubscribers && acl_a_board',
					'cat' => array('ACP_SHOWSUBSCRIBERS'),
				),
			),
		);
	}
}
