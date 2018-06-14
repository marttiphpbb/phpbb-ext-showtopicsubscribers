<?php
/**
* phpBB Extension - marttiphpbb showsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showsubscribers\acp;
use marttiphpbb\showsubscribers\cnst;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\marttiphpbb\showsubscribers\acp\main_module',
			'title'		=> cnst::L_ACP,
			'modes'		=> [
				'settings'	=> [
					'title' => cnst::L_ACP . '_SETTINGS',
					'auth' => 'ext_marttiphpbb/showsubscribers && acl_a_board',
					'cat' => [
						cnst::L_ACP,
					],
				],
			],
		];
	}
}
