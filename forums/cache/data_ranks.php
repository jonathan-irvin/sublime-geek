<?php
if (!defined('IN_PHPBB')) exit;
$expired = (time() > 1288277930) ? true : false;
if ($expired) { return; }

$data =  unserialize('a:2:{s:6:"normal";a:7:{i:0;a:3:{s:10:"rank_title";s:12:"Sublime Geek";s:8:"rank_min";s:4:"1000";s:10:"rank_image";s:0:"";}i:1;a:3:{s:10:"rank_title";s:13:"Seasoned Geek";s:8:"rank_min";s:3:"500";s:10:"rank_image";s:0:"";}i:2;a:3:{s:10:"rank_title";s:14:"Dedicated Geek";s:8:"rank_min";s:3:"250";s:10:"rank_image";s:0:"";}i:3;a:3:{s:10:"rank_title";s:10:"Geeky Geek";s:8:"rank_min";s:3:"100";s:10:"rank_image";s:0:"";}i:4;a:3:{s:10:"rank_title";s:11:"Just a Geek";s:8:"rank_min";s:2:"50";s:10:"rank_image";s:0:"";}i:5;a:3:{s:10:"rank_title";s:11:"Kinda Geeky";s:8:"rank_min";s:2:"10";s:10:"rank_image";s:0:"";}i:6;a:3:{s:10:"rank_title";s:7:"Geeklet";s:8:"rank_min";s:1:"0";s:10:"rank_image";s:0:"";}}s:7:"special";a:4:{i:1;a:2:{s:10:"rank_title";s:14:"CEO / Director";s:10:"rank_image";s:0:"";}i:2;a:2:{s:10:"rank_title";s:17:"Chief Ops Officer";s:10:"rank_image";s:0:"";}i:3;a:2:{s:10:"rank_title";s:8:"Director";s:10:"rank_image";s:0:"";}i:25;a:2:{s:10:"rank_title";s:15:"Product Analyst";s:10:"rank_image";s:0:"";}}}');

?>