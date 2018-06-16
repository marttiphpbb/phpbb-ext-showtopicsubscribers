<?php
/**
* phpBB Extension - marttiphpbb showtopicsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showtopicsubscribers\service;

use phpbb\db\driver\factory as db;
use phpbb\auth\auth;
use phpbb\config\db as config;
use phpbb\controller\helper;
use phpbb\template\twig\twig as template;
use phpbb\user;
use phpbb\language\language;
use marttiphpbb\showtopicsubscribers\util\cnst;

class topic_subscribers
{
	protected $db;
	protected $auth;
	protected $config;
	protected $helper;
	protected $php_ext;
	protected $template;
	protected $user;
	protected $language;
	protected $topics_watch_table;

	public function __construct(
		auth $auth,
		config $config,
		helper $helper,
		string $php_ext,
		template $template,
		user $user,
		language $language,
		string $topics_watch_table
	)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->php_ext = $php_ext;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->topics_watch_table;
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

	/**
	* Queries the session table to get information about online users
	* @param int $item_id Limits the search to the item with this id
	* @param string $item The name of the item which is stored in the session table as session_{$item}_id
	* @return array An array containing the ids of online, hidden and visible users, as well as statistical info
	*/
	function obtain_users_online($item_id = 0, $item = 'forum')
	{
		global $db, $config;

		$reading_sql = '';
		if ($item_id !== 0)
		{
			$reading_sql = ' AND s.session_' . $item . '_id = ' . (int) $item_id;
		}

		$online_users = array(
			'online_users'			=> array(),
			'hidden_users'			=> array(),
			'total_online'			=> 0,
			'visible_online'		=> 0,
			'hidden_online'			=> 0,
			'guests_online'			=> 0,
		);

		if ($config['load_online_guests'])
		{
			$online_users['guests_online'] = obtain_guest_count($item_id, $item);
		}

		// a little discrete magic to cache this for 30 seconds
		$time = (time() - (intval($config['load_online_time']) * 60));

		$sql = 'SELECT s.session_user_id, s.session_ip, s.session_viewonline
			FROM ' . SESSIONS_TABLE . ' s
			WHERE s.session_time >= ' . ($time - ((int) ($time % 30))) .
				$reading_sql .
			' AND s.session_user_id <> ' . ANONYMOUS;
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			// Skip multiple sessions for one user
			if (!isset($online_users['online_users'][$row['session_user_id']]))
			{
				$online_users['online_users'][$row['session_user_id']] = (int) $row['session_user_id'];
				if ($row['session_viewonline'])
				{
					$online_users['visible_online']++;
				}
				else
				{
					$online_users['hidden_users'][$row['session_user_id']] = (int) $row['session_user_id'];
					$online_users['hidden_online']++;
				}
			}
		}
		$online_users['total_online'] = $online_users['guests_online'] + $online_users['visible_online'] + $online_users['hidden_online'];
		$db->sql_freeresult($result);

		return $online_users;
	}

	/**
	* Uses the result of obtain_users_online to generate a localized, readable representation.
	* @param mixed $online_users result of obtain_users_online - array with user_id lists for total, hidden and visible users, and statistics
	* @param int $item_id Indicate that the data is limited to one item and not global
	* @param string $item The name of the item which is stored in the session table as session_{$item}_id
	* @return array An array containing the string for output to the template
	*/
	function obtain_users_online_string($online_users, $item_id = 0, $item = 'forum')
	{
		global $config, $db, $user, $auth, $phpbb_dispatcher;

		$user_online_link = $rowset = array();
		// Need caps version of $item for language-strings
		$item_caps = strtoupper($item);

		if (count($online_users['online_users']))
		{
			$sql_ary = array(
				'SELECT'	=> 'u.username, u.username_clean, u.user_id, u.user_type, u.user_allow_viewonline, u.user_colour',
				'FROM'		=> array(
					USERS_TABLE	=> 'u',
				),
				'WHERE'		=> $db->sql_in_set('u.user_id', $online_users['online_users']),
				'ORDER_BY'	=> 'u.username_clean ASC',
			);

			/**
			* Modify SQL query to obtain online users data
			*
			* @event core.obtain_users_online_string_sql
			* @var	array	online_users	Array with online users data
			*								from obtain_users_online()
			* @var	int		item_id			Restrict online users to item id
			* @var	string	item			Restrict online users to a certain
			*								session item, e.g. forum for
			*								session_forum_id
			* @var	array	sql_ary			SQL query array to obtain users online data
			* @since 3.1.4-RC1
			* @changed 3.1.7-RC1			Change sql query into array and adjust var accordingly. Allows extension authors the ability to adjust the sql_ary.
			*/
			$vars = array('online_users', 'item_id', 'item', 'sql_ary');
			extract($phpbb_dispatcher->trigger_event('core.obtain_users_online_string_sql', compact($vars)));

			$result = $db->sql_query($db->sql_build_query('SELECT', $sql_ary));
			$rowset = $db->sql_fetchrowset($result);
			$db->sql_freeresult($result);

			foreach ($rowset as $row)
			{
				// User is logged in and therefore not a guest
				if ($row['user_id'] != ANONYMOUS)
				{
					if (isset($online_users['hidden_users'][$row['user_id']]))
					{
						$row['username'] = '<em>' . $row['username'] . '</em>';
					}

					if (!isset($online_users['hidden_users'][$row['user_id']]) || $auth->acl_get('u_viewonline') || $row['user_id'] === $user->data['user_id'])
					{
						$user_online_link[$row['user_id']] = get_username_string(($row['user_type'] <> USER_IGNORE) ? 'full' : 'no_profile', $row['user_id'], $row['username'], $row['user_colour']);
					}
				}
			}
		}

		/**
		* Modify online userlist data
		*
		* @event core.obtain_users_online_string_before_modify
		* @var	array	online_users		Array with online users data
		*									from obtain_users_online()
		* @var	int		item_id				Restrict online users to item id
		* @var	string	item				Restrict online users to a certain
		*									session item, e.g. forum for
		*									session_forum_id
		* @var	array	rowset				Array with online users data
		* @var	array	user_online_link	Array with online users items (usernames)
		* @since 3.1.10-RC1
		*/
		$vars = array(
			'online_users',
			'item_id',
			'item',
			'rowset',
			'user_online_link',
		);
		extract($phpbb_dispatcher->trigger_event('core.obtain_users_online_string_before_modify', compact($vars)));

		$online_userlist = implode(', ', $user_online_link);

		if (!$online_userlist)
		{
			$online_userlist = $user->lang['NO_ONLINE_USERS'];
		}

		if ($item_id === 0)
		{
			$online_userlist = $user->lang['REGISTERED_USERS'] . ' ' . $online_userlist;
		}
		else if ($config['load_online_guests'])
		{
			$online_userlist = $user->lang('BROWSING_' . $item_caps . '_GUESTS', $online_users['guests_online'], $online_userlist);
		}
		else
		{
			$online_userlist = sprintf($user->lang['BROWSING_' . $item_caps], $online_userlist);
		}
		// Build online listing
		$visible_online = $user->lang('REG_USERS_TOTAL', (int) $online_users['visible_online']);
		$hidden_online = $user->lang('HIDDEN_USERS_TOTAL', (int) $online_users['hidden_online']);

		if ($config['load_online_guests'])
		{
			$guests_online = $user->lang('GUEST_USERS_TOTAL', (int) $online_users['guests_online']);
			$l_online_users = $user->lang('ONLINE_USERS_TOTAL_GUESTS', (int) $online_users['total_online'], $visible_online, $hidden_online, $guests_online);
		}
		else
		{
			$l_online_users = $user->lang('ONLINE_USERS_TOTAL', (int) $online_users['total_online'], $visible_online, $hidden_online);
		}

		/**
		* Modify online userlist data
		*
		* @event core.obtain_users_online_string_modify
		* @var	array	online_users		Array with online users data
		*									from obtain_users_online()
		* @var	int		item_id				Restrict online users to item id
		* @var	string	item				Restrict online users to a certain
		*									session item, e.g. forum for
		*									session_forum_id
		* @var	array	rowset				Array with online users data
		* @var	array	user_online_link	Array with online users items (usernames)
		* @var	string	online_userlist		String containing users online list
		* @var	string	l_online_users		String with total online users count info
		* @since 3.1.4-RC1
		*/
		$vars = array(
			'online_users',
			'item_id',
			'item',
			'rowset',
			'user_online_link',
			'online_userlist',
			'l_online_users',
		);
		extract($phpbb_dispatcher->trigger_event('core.obtain_users_online_string_modify', compact($vars)));

		return array(
			'online_userlist'	=> $online_userlist,
			'l_online_users'	=> $l_online_users,
		);
	}

}
