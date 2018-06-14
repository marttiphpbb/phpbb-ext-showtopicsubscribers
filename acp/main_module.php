<?php
/**
* phpBB Extension - marttiphpbb showsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showsubscribers\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$user = $phpbb_container->get('user');
		$config = $phpbb_containter->get('config');
		$template = $phpbb_container->get('template');
		$request = $phpbb_container->get('request');
		$language = $phpbb_container->get('language');

		$language->add_lang_ext('acp', 'marttiphpbb/showsubscribers');
		add_form_key('marttiphpbb/showsubscribers');

		switch ($mode)
		{
			case 'settings':
				$this->tpl_name = 'settings';
				$this->page_title = $user->lang('ACP_MARTTIPHPBB_SHOWSUBSCRIBERS_SETTINGS');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/showsubscribers'))
					{
						trigger_error('FORM_INVALID');
					}

					$config->set('showsubscribers_ajax_treshold', $request->variable('showsubscribers_ajax_treshold', 25));
					$config->set('showsubscribers_count_only', $request->variable('showsubscribers_count_only', 0));

					trigger_error($user->lang('ACP_SHOWSUBCRIBERS_SETTINGS_SAVED') . adm_back_link($this->u_action));
				}

				$template->assign_vars([
					'U_ACTION'							=> $this->u_action,
					'MARTTIPHPBB_SHOWSUBSCRIBERS_TRESHOLD'			=> $config['showsubscribers_treshold'],
					'S_MARTTIPHPBB_SHOWSUBSCRIBERS_COUNT_ONLY'		=> $config['showsubscribers_count_only'],					'S_MARTTIPHPBB_SHOWSUBSCRIBERS_COUNT_ONLY'		=> $config['showsubscribers_count_only'],
				]);

				break;
		}
	}
}
