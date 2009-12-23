<?php

/* 
Based on jQuery Autocomplete plugin, http://jquery.bassistance.de/autocomplete/
This is a "fake" database; real Ajax search would hit a database, not a php page.
 */

sleep(0);
$q = strtolower($_GET["q"]);
if (!$q) return;
$items = array(
"1000/1001"=>" ",
"1080/24P"=>" ",
"1080/60i"=>" ",
"1280x720"=>" ",
"16x9"=>" ",
"1.78"=>" ",
"1.85"=>" ",
"1920x1080"=>" ",
"Analog to Digital Conversion (ADC)"=>" ",
"Advanced Authoring Format (AAF)"=>" ",
"Aliasing"=>" ",
"Anamorphic"=>" ",
"Anti-Aliasing"=>" ",
"Aspect Ratio"=>" ",
"Capture Rate"=>" ",
"Charged Couple Device (CCD)"=>" ",
"Color Correction"=>" ",
"Color Enhancement"=>" ",
"Color Space"=>" ",
"Composite Video"=>" ",
"Component Video"=>" ",
"Compression"=>" ",
"DAC, Digital to Analog Conversion"=>" ",
"DAT, Digital Audio Tape"=>" ",
"Decibel (dB)"=>" ",
"D-Cinema"=>" ",
"Digital Television (DTV)"=>" ",
"Dolby Pro-Logic"=>" ",
"Dolby Surround"=>" ",
"Frame Rate"=>" ",
"Gamut"=>" ",
"High Definition (HD)"=>" ",
"High Definition Television (HDTV)"=>" ",
"Interlace Imaging"=>" ",
"Letterbox Format"=>" ",
"National Television Systems Committe (NTSC)"=>" ",
"Phase Alternation Line (PAL)"=>" ",
"Progressive Imaging"=>" ",
"Resolution"=>" ",
"RGB"=>" ",
"Standard Definition (SD)"=>" ",
"Standard Definition Television (SDTV)"=>" ",
"Upconversion"=>" ",
"Video Controller"=>" ",
"Y, R-Y, B-Y"=>" "
);

foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		echo "$key|$value\n";
	}
}

?>