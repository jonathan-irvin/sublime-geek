<?php
if (!defined('IN_PHPBB')) exit;
$expired = (time() > 1281419975) ? true : false;
if ($expired) { return; }

$data =  unserialize('a:4:{s:4:"name";s:8:"AcidTech";s:9:"copyright";s:36:"&copy; 2007-2009 Vjacheslav Trushkin";s:7:"version";s:5:"2.1.0";s:8:"filetime";i:1249676614;}');

?>