#!/bin/sh
# $Id: postrackercron.sh 131 2008-07-21 06:18:41Z stephenmg $
#cd ~/your_path_to_tracker
#/usr/local/bin/php mail.php
/usr/local/bin/php5 cron_updateallianceinfo.php
/usr/local/bin/php5 cron_updatesov.php

