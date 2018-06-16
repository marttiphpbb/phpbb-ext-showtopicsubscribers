<?php
/**
* phpBB Extension - marttiphpbb showtopicsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showtopicsubscribers\migrations;

use phpbb\db\migration\migration;
use marttiphpbb\showtopicsubscribers\util\cnst;

class mgr_1 extends migration
{
	static public function depends_on()
	{
		return [
			'\phpbb\db\migration\data\v32x\v321',
		];
	}

	public function update_data()
	{
		return [
			['config.add', [cnst::ID . '_treshold', 100]],

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
		];
	}
}
