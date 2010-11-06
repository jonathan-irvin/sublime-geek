<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

if(!mysql_num_rows( mysql_query("SHOW TABLES LIKE 'mod_ipmanager'"))) {
	if (!$_GET["install"]) {
		echo '
<p><strong>Not Yet Installed</strong></p>
<p>This addon module allows you to record IP addresses and what they are being used for.</p>
<p>To install it, click on the button below.</p>
<p><input type="button" value="Install IP Manager" onclick="window.location=\''.$modulelink.'&install=true\'"></p>
';
	} else {
		$query = "CREATE TABLE `mod_ipmanager` (`id` INT( 1 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,`ipaddress` VARCHAR( 16 ) NOT NULL ,`note` TEXT NOT NULL )";
		$result=mysql_query($query);
		header("Location: $modulelink");
		exit;
	}
} else {
	if ($_POST["ip"]) {
		foreach ($_POST["ip"] AS $id=>$ip) {
			$id = sanitize($id);
			$ip = sanitize($ip);
			$note = sanitize($_POST["note"][$id]);		
			update_query("mod_ipmanager",array("ipaddress"=>$ip,"note"=>$note),"id='$id'");
		}
	}
	if ($_POST["newip"]) {
		$newip = sanitize($_POST["newip"]);
		$newnote = sanitize($_POST["newnote"]);
		insert_query("mod_ipmanager",array("ipaddress"=>$newip,"note"=>$newnote));
	}
	if ($_GET["delete"]) {
		$id = sanitize($_GET["id"]);
		delete_query("mod_ipmanager","id='$id'");
	}
	$filterfield = sanitize($_POST["filterfield"]);
	$filtertype = sanitize($_POST["filtertype"]);
	$filtervalue = sanitize($_POST["filtervalue"]);
	echo '
<script language="JavaScript">
function doDelete(id) {
if (confirm("Are you sure you want to delete this IP?")) {
window.location="'.$modulelink.'&delete=true&id="+id;
}}
</script>
<form method="post" action="'.$modulelink.'">
<p align="center">Search for <select name="filterfield">
<option value="ipaddress"';
if ($filterfield=="ipaddress") { echo ' selected'; }
echo '>IP Address</option>
<option value="note"';
if ($filterfield=="note") { echo ' selected'; }
echo '>Note</option>
<select> that <select name="filtertype">
<option';
if ($filtertype=="starts with") { echo ' selected'; }
echo '>starts with</option>
<option';
if ($filtertype=="ends with") { echo ' selected'; }
echo '>ends with</option>
<option';
if ($filtertype=="contains") { echo ' selected'; }
echo '>contains</option>
</select> <input type="text" name="filtervalue" size="30" value="'.$filtervalue.'"> <input type="submit" value="Filter"></p>

<div class="tablebg">
<table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
<tr><th width="120">IP Address</th><th>Note</th><th width="20"></th></tr>
';
	$id="";
	$query = "SELECT * FROM mod_ipmanager";
	if ($filterfield) {
		$query.= " WHERE $filterfield";
		if ($filtertype=="starts with") {
			$query.= " LIKE '$filtervalue%'";
		} elseif ($filtertype=="ends with") {
			$query.= " LIKE '%$filtervalue'";
		} else {
			$query.= " LIKE '%$filtervalue%'";
		}
	}
	$query.= " ORDER BY INET_ATON(ipaddress) ASC"; 
	$result=mysql_query($query);
	while ($data = mysql_fetch_array($result)) {
		$id = $data["id"];
		$ipaddress = $data["ipaddress"];
		$note = $data["note"];
		echo '<tr><td><input type="text" name="ip['.$id.']" style="width:100%" value="'.$ipaddress.'"></td><td><input type="text" name="note['.$id.']" style="width:100%" value="'.$note.'"></td><td align="center"><a href="#" onClick="doDelete(\''.$id.'\');return false"><img src="images/delete.gif" width="16" height="16" border="0" alt="Delete"></a></td></tr>';
	}
	if (!$id) {
		echo '<tr><td colspan="3" align="center">No Records Found</td></tr>';
	}
	echo '
</table>
</div>

<p align="center"><input type="submit" value="Save Changes"></p>
<p align="center"><strong>Add New IP</strong> IP Address: <input type="text" name="newip" size="20"> Note: <input type="text" name="newnote" size="75"> <input type="submit" value="Add IP"></p>
</form>
';
}

?>