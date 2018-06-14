<?php
/**
* phpBB Extension - marttiphpbb showtopicsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showtopicsubscribers\migrations;

use phpbb\db\migration\migration;
use marttiphpbb\showtopicsubscribers\util\cnst;

class v_1_0_0 extends migration
{

	public function update_data()
	{
		return [
			['config.add', ['showtopicsubscribers_treshold', 100]],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				cnst::L_ACP,
			]],

			['module.add', [
				'acp',
				cnst::L_ACP,
				[
					'module_basename'	=> '\marttiphpbb\showtopicsubscribers\acp\main_module',
					'modes'				=> [
						'settings',
					],
				],
			]],

			['permission.add', ['u_showtopicsubscribers_view']],

		];
	}
}
