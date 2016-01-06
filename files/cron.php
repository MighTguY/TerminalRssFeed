<?php
include_once 'connect.php';
include_once 'RssConfig.php';
$obj = new RssConfig();

print "Please wait We are setting up this for you ";
if (is_connected()) {
	$obj->callOnLoadALL();
}
print "Its Done! Enjoy this :)  ";
?>
