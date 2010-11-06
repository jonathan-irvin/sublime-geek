<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

/*

*******************************************************************************
* ADDON ADMIN MODULES                                                         *
*******************************************************************************

We've made addon admin modules as easy to create as possible. You simply create
your file and output content in the normal way for display on the screen.

For links to retain the module, use the $modulelink var like this:

    <a href="$modulelink&var1=&var2=">x</a>

And if you want to display/use multiple files within the WHMCS admin page, you
can do this using an if or switch statement inside the module to include
additional files based on a variable, for example:

    if (!$action)
        include("step1.php");
    elseif ($action=="step2")
        include("step2.php");

*******************************************************************************

*/
?>

<p>This is an example module.  It's very simply to create your own and this file is an example.</p>

<p>You can run queries, calculate statistics or just display information which you need quick access to all from an addon module.</p>

<p>You can look at the code in "<i>modules/admin/example/example.php</i>" to see how it is constructed.</p>

<br /><br />