<?php
/**
* phpBB Extension - marttiphpbb showtopicsubscribers
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\showtopicsubscribers\service;

use phpbb\db\driver\factory as db;
use marttiphpbb\showtopicsubscribers\util\cnst;

class topic_subscribers
{
	protected $db;
	protected $topics_watch_table;
	protected $users_table;

	public function __construct(
		db $db,
		string $topics_watch_table,
		string $users_table
	)
	{
		$this->db = $db;
		$this->topics_watch_table = $topics_watch_table;
		$this->users_table = $users_table;
	}

	public function get_count(int $topic_id):int
	{
		$sql = 'select count(*)
			from ' . $this->topics_watch_table . '
			where topic_id = ' . $topic_id;

		$result = $this->db->sql_query($sql);
		$count = $this->db->sql_fetchfield('count(*)');
		$this->db->sql_freeresult($result);

		return $count;
	}

	function get_string(int $topic_id):string
	{
		$users = [];

		$sql = 'select u.username, u.user_id,
			u.user_type, u.user_colour
			from ' . $this->users_table . ' u, ' . $this->topics_watch_table . ' w
			where w.topic_id = ' . $topic_id . '
				and w.user_id = u.user_id
			order by u.username_clean asc';
		$result = $this->db->sql_query($sql);
		$rowset = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		foreach ($rowset as $row)
		{
			$users[$row['user_id']] = get_username_string(($row['user_type'] <> USER_IGNORE) ? 'full' : 'no_profile', $row['user_id'], $row['username'], $row['user_colour']);
		}

		return implode(', ', $users);
	}
}
