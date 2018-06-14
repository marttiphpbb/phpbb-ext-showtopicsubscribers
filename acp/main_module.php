<?php
/**
* phpBB Extension - marttiphpbb showtopicsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showtopicsubscribers\acp;

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

		$language->add_lang_ext('acp', 'marttiphpbb/showtopicsubscribers');
		add_form_key('marttiphpbb/showtopicsubscribers');

		switch ($mode)
		{
			case 'settings':
				$this->tpl_name = 'settings';
				$this->page_title = $user->lang('ACP_MARTTIPHPBB_SHOWTOPICSUBSCRIBERS_SETTINGS');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/showtopicsubscribers'))
					{
						trigger_error('FORM_INVALID');
					}

					$config->set('showtopicsubscribers_ajax_treshold', $request->variable('showtopicsubscribers_ajax_treshold', 25));
					$config->set('showtopicsubscribers_count_only', $request->variable('showtopicsubscribers_count_only', 0));

					trigger_error($user->lang('ACP_SHOWSUBCRIBERS_SETTINGS_SAVED') . adm_back_link($this->u_action));
				}

				$template->assign_vars([
					'U_ACTION'							=> $this->u_action,
					'MARTTIPHPBB_SHOWTOPICSUBSCRIBERS_TRESHOLD'			=> $config['showtopicsubscribers_treshold'],
					'S_MARTTIPHPBB_SHOWTOPICSUBSCRIBERS_COUNT_ONLY'		=> $config['showtopicsubscribers_count_only'],					'S_MARTTIPHPBB_SHOWTOPICSUBSCRIBERS_COUNT_ONLY'		=> $config['showtopicsubscribers_count_only'],
				]);

				break;
		}
	}
}
