<?php
/**
* phpBB Extension - marttiphpbb showtopicsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showtopicsubscribers\acp;

use marttiphpbb\showtopicsubscribers\util\cnst;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$config = $phpbb_container->get('config');
		$template = $phpbb_container->get('template');
		$request = $phpbb_container->get('request');
		$language = $phpbb_container->get('language');

		$language->add_lang('acp', cnst::FOLDER);
		add_form_key(cnst::FOLDER);

		switch ($mode)
		{
			case 'settings':
				$this->tpl_name = 'settings';
				$this->page_title = $language->lang(cnst::L_ACP . '_SETTINGS');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key(cnst::FOLDER))
					{
						trigger_error('FORM_INVALID');
					}

					$config->set(cnst::ID . '_threshold', $request->variable('threshold', 0));

					trigger_error($language->lang(cnst::L_ACP . '_SETTINGS_SAVED') . adm_back_link($this->u_action));
				}

				$template->assign_vars([
					'U_ACTION'	=> $this->u_action,
					'THRESHOLD'	=> $config[cnst::ID . '_threshold'],
				]);

				break;
		}
	}
}
