<?php
######################################################################################
#  Copyright (C) 2012 Elite.So. All rights reserved.
#
#  This program is free software; you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation; either version 2 of the License, or
#  (at your option) any later version.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
######################################################################################

header("Content-Type: text/html\n\n");

function cleanBlanks($fullPath, $file)
{
//$fullPath = test file to read 
//$file = test file to write 
$filecontent = file($fullPath); // put content in array 
$num_lines = count($filecontent); // determine num of lines 
$fp = fopen($file, 'w'); // create file pointer 
for($i = 1; $i < $num_lines; $i++) // start loop 
{ 
    $line = trim($filecontent[$i]); // trim line 
    if(!empty($line)) // if not empty 
    { 
        if($i < count($filecontent) - 1) 
        { 
            fwrite($fp, $line . "\n"); // add NEW line 
        } 
        else { 
            fwrite($fp, $line); 
        } 
     } 
} 
fclose($fp); // close file pointer 
shell_exec("rm -f ".$fullpath); //delete the infile
shell_exec("cp ".$file." ".$fullpath); //replace the infile with the temp file
shell_exec("rm -f ".$file); //delete the temp file
file_put_contents($fullPath, "\n", FILE_APPEND | LOCK_EX); //append a new line to the infile (caused issues with crontab if not added to file)
}

// *** Common variables ***
$cpAppName = 'Crontab Admin';
$cpAppVersion = '1.0 Beta Version';

// *** update stuff *** //
function checkUpdate()
{
	$newv = file_get_contents('http://www.elite.so/cronmgr/vrsctl.db');
	$thisv = shell_exec("cat /usr/local/cpanel/whostmgr/docroot/cgi/cronmgr/verctl.db");
	if ($newv != $thisv)
	{
		return true;
	}
	else {
		return false;
	}
}
// *** end update stuff *** //
$user = getenv('REMOTE_USER');
if($user != "root") { echo "You do not have the proper permissions to access SS5 Manager..."; exit; }
$run = "Down";
$checkstat = shell_exec("ps -A");
if(strstr($checkstat,"crond")) { $run = "UP"; }
?>
<html>
<head>
<title><?php echo $cpAppName; ?></title>
<meta name="description" content="WHM Plug-in to edit Crontab for cPanel servers" />
<link rel='stylesheet' type='text/css' href='/themes/x/style_optimized.css' />
<script type="text/javascript">
function okay() {
if(confirm('Are you sure of save configuration?')) {
document.getElementById('okay').submit();
}
return false;
}
function clog() {
document.getElementById('log').submit();
}
</script>
<style>
div#wrap {
margin: 0 auto;
width: 700px;
}
</style>
</head>
<body class="yui-skin-sam">
<div id="pageheader">
        <div id="breadcrumbs">
                <p>&nbsp;<a href="/scripts/command?PFILE=main">Main</a> &gt;&gt; <a href="cronmgr.php" class="active"><?php echo 
$cpAppName; ?></a></p>
        </div>
<div id="doctitle"><h1><?php echo $cpAppName; ?> (v<?php echo $cpAppVersion; ?>)</h1></div>
</div>
<div id="wrap">
<table cellpadding="0" cellspacing="0">
<tr align="center">
<td width="180"><img src="cronmgr/home.png" alt="Home" /></td>
<td width="180"><img src="cronmgr/configss5.png" alt="Edit Crontab" /></td>
</tr>
<tr align="center">
<td><a href="cronmgr.php">Home</a></td>
<td><a href="cronmgr.php?op=edit">Crontab Editor</a></td>
</tr>
</table><br />
<?php
$op = &$_GET['op'];
switch($op) {
case "edit":
if(isset($_POST['conf'])) {
$conf = $_POST['conf'];
//delete any old backups of cron by this script
shell_exec("rm -f /root/cron.backup");
// backup crontab before editing 
shell_exec("crontab -l > /root/cron.backup");
//write to temp cron
file_put_contents("/root/cron.temp", $conf);
cleanBlanks("/root/cron.temp", "/root/cron2.temp");
//import new cron
shell_exec("crontab /root/cron.temp");
//remove temp file
shell_exec("rm -f /root/cron.temp");
echo "<p><b>Configuration has been updated.</b></p>";
}
?>
<form action="cronmgr.php?op=edit" method="post" id="okay"><textarea name="conf" cols="80" rows="20"><?=shell_exec("crontab -l")?></textarea><br />Restart CronD? <input type="checkbox" name="c" /><br /><br /><input type="submit" value="Update!" onClick="okay();return false;" /></form>
<?
break;

default:
echo "Socks 5 Service Status: <font style=\"color: #0c0\"><b>{$run}</b></font>";
if (checkUpdate())
{
	echo '<br><p><b><u><a href="cronmgr.php?op=update">Update Available!</a></u></b></p><br>';
}
?>
<p style="color: #03F"><b>What is Cron?</b></p>
<p>Cron is used to schedule jobs (commands or shell scripts) to run periodically at fixed times, dates, or intervals.<br></p>
<p style="color: #03F"><b>About Crontab Admin</b></p>
<p>Crontab Admin was created so cPanel & WHM System Administrators can edit the crontab file of the dedicated server without needing to use ssh.<br></p>
<p>For Support Visit <a href="http://www.elite.so" target='_blank'>Elite.So</a></p>
<? } ?>
<p>SS5 Manager: v<?php echo $cpAppVersion; ?></p><p>©2013, <a href="http://www.elite.so" target='_blank'>Elite.So</a></p>
</div>
</body>
</html>
