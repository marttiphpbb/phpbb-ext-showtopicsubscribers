<?php
/**
* phpBB Extension - marttiphpbb showsubscribers
* @copyright (c) 2015 marttiphpbb <info@martti.be>
* @license http://opensource.org/licenses/MIT
*/

namespace marttiphpbb\showsubscribers\migrations;

use phpbb\db\migration\migration;

class v_1_0_0 extends migration
{

	public function update_data()
	{
		return array(
			array('config.add', array('showsubscribers_treshold', 25)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_SHOWSUBSCRIBERS'
			)),

			array('module.add', array(
				'acp',
				'ACP_SHOWSUBSCRIBERS',
				array(
					'module_basename'	=> '\marttiphpbb\showsubscribers\acp\main_module',
					'modes'				=> array(
						'settings',
					),
				),
			)),

			array('permission.add', array('u_showsubscribers_view')),

		);
	}

	public function update_schema()
	{
		return array();
	}

	public function revert_schema()
	{
		return array();
	}
}
