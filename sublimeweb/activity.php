<?php

/* 
This is a "fake" database; real Ajax search would hit database, not a php page.
 */

	$l = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ';
	$types = array("blog","forum","wiki");
	$subjects = array(
		"blu ray dvd on 1080i hdtv",
		"SONY KP53HS10 Flicker problem",
		"Why do I still have black bars with a widescreen TV?",
		"Streaming HD Online?",
		"Sony Bravia Play-Doh Ad",
		"I'm having trouble finding HD programming",
		"SONY KP53HS10 flicker problem",
		"HD quality video converter",
		"Imax at home?",
		"England to ban Plasma TV's!?",
		"Question about Tivo &amp; Comcast",
		"high def dvds",
		"Beijing 2008, HD Broadcast rights",
		"80in HDTV Ready Holographic TV"
	);
	$authors = array(
		"trekker",
		"Tex HD",
		"willienillie",
		"Victoriano",
		"willienillie",
		"Victoriano",
		"Supaflyz",
		"charlie77",
		"Panchito"
	);
for ($i = 0; $i < 1; $i++)
{
	srand();
	$s = rand(0, strlen($l)-10);
	$e = rand($s, (strlen($l) - strlen($s))+10);
	$str = substr($l, $s, $e);
	$type = rand(0,count($types)-1);
	$subject = rand(0,count($subjects)-1);
	$author = rand(0,count($authors)-1);
	$alt = ucfirst($types[$type]);
	echo <<<HERE_DOC
	<div>
		<div class="entry clearfix">
			<div class="icon"><img src="img/icontext-{$types[$type]}.png" alt="{$alt}" width="24" height="24" /></div>
			<div class="title"><a href="#a">{$subjects[$subject]}</a> by {$authors[$author]}</div>
			<div class="time stamp_{$_REQUEST['timestamp']}">&#60; 1 min ago</div>
		</div>
	</div>
HERE_DOC;
}

?>
