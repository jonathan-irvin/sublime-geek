POS-Tracker Installation
--------------------------------------------

You must already have a MYSQL database.

Edit the eveconfig/config.php and eveconfig/mailconfig.php files if required.
eveconfig/dbconfig.php will be edited by the install script.
Upload to your host
Visit http://YOURPOSTRACKERURL/install.php
Follow the steps of the installation.

Delete the install.php file


By default, the installation creates an admin user.
Register your Character in-game and give that character access via the administration.

If upgrading from a previous 3.x version, upload the upgrade pack and visit http://YOURPOSTRACKERURL/upgrade.php




// $Id: README.txt 176 2008-09-28 17:38:10Z stephenmg $ //


DEPRECATED! 3.x is not compatible with 2.x

Notes:
--------------------------------------------
POS-Tracker 3.0.0 Beta 2:
Email alerts are in, but the ability to change the current 'owner' without modifying the database manually is not.
POS-Tracker 3.0.0 Beta 1:
POS-Tracker 3.0.0 is not compatible with 2.x. It is still subject to change and may have bugs. Also note, anyone using the email alerts or outpost will find them missing. They will be added later.

ChangeLog:
--------------------------------------------------------------------------
Changes from POS-Tracker 3.0.0 BETA 1 to 3.0.0 BETA 2 (Rev 140)
readme.txt - updated to 3.0.0 BETA 2
includes/class.posmailer.php - added versioning info
includes/phpmailer/ - 3rd party php class to handle the sending of email
includes/class.posmailer.php - extension of phpmailer class for pos-tracker
eveconfig/mailconfig.php - added for configuration options for phpmailer
register.php - added email validation code sending
install.php - changed the default access level for the Admin account from 4 to 5. Fixed a line causing errors when trying to redirect, wrong class referenced, Changed the default Admin account to Admin, will make it configurable in later version with installation script update.
themes\posmanger\style\pos.css - fixed the order of the css elements to fix an error with the some of the links not being underlined
class.pos.php - added version tracking to file. Added GetAllUsersWithAccess() to pull users with a certain access level and added  posoptimaluptime() to calculate pos optimal fuel levels. Improved API error reporting to pull the description of the error. Also fixed the API_SaveKey() to use a time 6 hours before the key was added rather then the current time.
dbfunctions.php, eveclass.php, eveRender.class.php - added version tracking info to files
adodb/ - updated to use an official newer version
install/install_database.sql - updated for empyrean age, Black Rise added
install/10000069.sql - Black Rise moons
istall/100000**.sql - Exported using empyrean age data export
importfit.php - wrong version, included new version to work with 3.0
fileporter.xml.php - was missing
class.pos.php - fixed hard refrences to the default table prefix pos2_
Changes from POS-Tracker 2.1.0 BETA 2 to 3.0.0 BETA 1 (Rev 132)
Templating system using Smarty added thanks to DeTox MinRohim
Adodb support added thanks to DeTox MinRohim
All functions moved to class.pos.php thanks to DeTox MinRohim
Import/Export of tower fittings that are compatible with the MyPOS tool
admin.php - fixed the table prefix switch code for installing moons
install.php - fixed the table prefix switch code, changed the admin account access level from 4 to 5, and fix a bug on line 151 that had the wrong object referenced
install/install_database.sql - changed the user table to add email opt in, validation code, and email validated field