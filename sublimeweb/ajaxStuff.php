<?
sleep(1);
$length = 140;

if(strlen($_POST["newNote"]) > $length){
	$_POST["newNote"] = substr($_POST["newNote"],0,$length)."...";
}
echo $_POST["newNote"];
?>