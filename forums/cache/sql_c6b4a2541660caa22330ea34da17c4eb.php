<?php
if (!defined('IN_PHPBB')) exit;

/* SELECT m.*, u.user_colour, g.group_colour, g.group_type FROM (bb_moderator_cache m) LEFT JOIN bb_users u ON (m.user_id = u.user_id) LEFT JOIN bb_groups g ON (m.group_id = g.group_id) WHERE m.display_on_index = 1 AND m.forum_id IN (4, 14, 16, 18, 21, 6, 7, 8, 9, 23, 22, 19, 11, 12, 13) */

$expired = (time() > 1261607002) ? true : false;
if ($expired) { return; }

$this->sql_rowset[$query_id] = array();

?>