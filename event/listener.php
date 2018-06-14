<?php
/**
* phpBB Extension - marttiphpbb showtopicsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showtopicsubscribers\event;

use phpbb\auth\auth;
use phpbb\config\db as config;
use phpbb\controller\helper;
use phpbb\template\twig\twig as template;
use phpbb\user;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{

	/* @var auth */
	protected $auth;

	/* @var config */
	protected $config;

	/* @var helper */
	protected $helper;

	/* @var string */
	protected $php_ext;

	/* @var template */
	protected $template;

	/* @var user */
	protected $user;

	/**
	* @param auth				$auth
	* @param config				$config
	* @param helper				$helper
	* @param string				$php_ext
	* @param template			$template
	* @param user				$user
	*/
	public function __construct(
			auth $auth,
			config $config,
			helper $helper,
			$php_ext,
			template $template,
			user $user
		)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->php_ext = $php_ext;
		$this->template = $template;
		$this->user = $user;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'						=> 'core_user_setup',
			'core.page_footer'						=> 'core_page_footer',
			'core.viewonline_overwrite_location'	=> 'core_viewonline_overwrite_location',
			'core.memberlist_view_profile'			=> 'core_memberlist_view_profile',
		];
	}

	public function core_user_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];

		$lang_set_ext[] = [
			'ext_name' => 'marttiphpbb/showtopicsubscribers',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;

	}

	public function core_page_footer($event)
	{
		$this->template->assign_vars([]);
	}

	public function core_viewonline_overwrite_location($event)
	{
		if (strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/transactions') === 0)
		{
			$event['location'] = $this->user->lang('CC_VIEWING_TRANSACTIONS');
			$event['location_url'] = $this->helper->route('marttiphpbb_cc_transactionlist_controller');
		}
	}

	public function core_memberlist_view_profile($event)
	{
		if (!$this->auth->acl_get('u_cc_viewtransactions'))
		{
			return;
		}

		$member = $event['member'];

		$memberdays = max(1, round((time() - $member['user_regdate']) / 86400));
		$transactions_per_day = $member['user_cc_transaction_count'] / $memberdays;
		$percentage = ($this->config['cc_transaction_count']) ? min(100, ($member['user_cc_transaction_count'] / $this->config['cc_transaction_count']) * 100) : 0;

		$amount = $this->currency_transformer->transform($member['user_cc_balance']);

	}
}
