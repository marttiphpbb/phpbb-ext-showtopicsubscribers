<?php
/**
* phpBB Extension - marttiphpbb showtopicsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showtopicsubscribers\event;

use phpbb\event\data as event;
use phpbb\auth\auth;
use phpbb\config\db as config;
use phpbb\controller\helper;
use phpbb\template\twig\twig as template;
use phpbb\language\language;
use marttiphpbb\showtopicsubscribers\service\topic_subscribers;
use marttiphpbb\showtopicsubscribers\util\cnst;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $auth;
	protected $config;
	protected $helper;
	protected $php_ext;
	protected $template;
	protected $language;
	protected $topic_subscribers;

	public function __construct(
			auth $auth,
			config $config,
			helper $helper,
			string $php_ext,
			template $template,
			language $language,
			topic_subscribers $topic_subscribers
	)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->php_ext = $php_ext;
		$this->template = $template;
		$this->language = $language;
		$this->topic_subscribers = $topic_subscribers;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.viewtopic_assign_template_vars_before'
				=> 'core_viewtopic_assign_template_vars_before',
		];
	}

	public function core_viewtopic_assign_template_vars_before(event $event)
	{
		if (!$this->auth->acl_get('u_cc_viewtransactions'))
		{
			return;
		}

		$this->language->add_lang('common', cnst::L);
	}
}
