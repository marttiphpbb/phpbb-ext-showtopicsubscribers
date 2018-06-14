<?php
/**
* phpBB Extension - marttiphpbb showsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showsubscribers\migrations;

use phpbb\db\migration\migration;
use marttiphpbb\showsubscribers\util\cnst;

class v_1_0_0 extends migration
{

	public function update_data()
	{
		return [
			['config.add', ['showsubscribers_treshold', 100]],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				cnst::L_ACP,
			]],

			['module.add', [
				'acp',
				cnst::L_ACP,
				[
					'module_basename'	=> '\marttiphpbb\showsubscribers\acp\main_module',
					'modes'				=> [
						'settings',
					],
				],
			]],

			['permission.add', ['u_showsubscribers_view']],

		];
	}
}
