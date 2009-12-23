<?php
if (!defined('IN_PHPBB')) exit;
$expired = (time() > 1282302812) ? true : false;
if ($expired) { return; }

$data =  unserialize('a:4:{s:4:"name";s:5:"slagg";s:9:"copyright";s:25:"&copy; StylerBB.net, 2008";s:7:"version";s:5:"1.0.1";s:8:"filetime";i:1249603503;}');

?>