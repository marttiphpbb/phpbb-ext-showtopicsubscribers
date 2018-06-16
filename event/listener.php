<?php
/**
* phpBB Extension - marttiphpbb showtopicsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showtopicsubscribers\event;

use phpbb\event\data as event;
use phpbb\config\db as config;
use phpbb\template\twig\twig as template;
use phpbb\language\language;
use marttiphpbb\showtopicsubscribers\service\topic_subscribers;
use marttiphpbb\showtopicsubscribers\util\cnst;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $config;
	protected $template;
	protected $language;
	protected $topic_subscribers;

	public function __construct(
			config $config,
			template $template,
			language $language,
			topic_subscribers $topic_subscribers
	)
	{
		$this->config = $config;
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
		$this->language->add_lang('common', cnst::FOLDER);
		$topic_id = $event['topic_id'];

		$count = $this->topic_subscribers->get_count($topic_id);
		$treshold = $this->config[cnst::ID . '_treshold'];

		if (!$count || $count > $treshold)
		{
			$list = $this->language->lang(cnst::L . '_NO_LIST', $count);
		}
		else
		{
			$list = $this->topic_subscribers->get_string($topic_id);
			$list = $this->language->lang(cnst::L . '_LIST', $count, $list);
		}

		$this->template->assign_vars([
			'MARTTIPHPBB_SHOWTOPICSUBSCRIBERS_LIST' => $list,
		]);
	}
}
