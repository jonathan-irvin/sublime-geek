<?php
if (!defined('IN_PHPBB')) exit;
$expired = (time() > 1282302812) ? true : false;
if ($expired) { return; }

$data =  unserialize('a:5:{s:4:"name";s:5:"slagg";s:9:"copyright";s:25:"&copy; StylerBB.net, 2009";s:7:"version";s:5:"1.0.1";s:14:"parse_css_file";b:0;s:8:"filetime";i:1249603505;}');

?>