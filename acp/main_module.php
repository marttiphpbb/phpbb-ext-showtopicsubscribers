<?php
/**
* phpBB Extension - marttiphpbb showsubscribers
* @copyright (c) 2015 marttiphpbb <info@martti.be>
* @license http://opensource.org/licenses/MIT
*/

namespace marttiphpbb\showsubscribers\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $user, $request, $template;

		$user->add_lang_ext('marttiphpbb/showsubscribers', 'acp');
		add_form_key('marttiphpbb/showsubscribers');

		switch ($mode)
		{
			case 'settings':
				$this->tpl_name = 'settings';
				$this->page_title = $user->lang('ACP_SHOWSUBSCRIBERS_SETTINGS');

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

				$template->assign_vars(array(
					'U_ACTION'							=> $this->u_action,
					'SHOWSUBSCRIBERS_TRESHOLD'			=> $config['showsubscribers_ajax_treshold'],
					'S_SHOWSUBSCRIBERS_COUNT_ONLY'		=> $config['showsubscribers_count_only'],
				));

				break;
		}
	}
}
