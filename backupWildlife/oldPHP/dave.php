<?php
ini_set('session.save_handler', 'files');
session_start();
require_once("includes/functions/general.php"); 
require("includes/functions/login.php");
require("includes/config.php");
include("includes/functions/menucreator.php"); 
require("includes/XPertMailer/XPertMailer.php");
include("includes/functions/availability.php"); 
include("includes/functions/wbfuncs.php");

if($_SESSION['remote_addr'] == $_SERVER['REMOTE_ADDR'])
{
	if(isset($_GET['module'])) $modID = $_GET['module'];
	else $modID = DEFAULT_MOD;

	if(isset($_GET['section']))
	{
		$PermLevel = CheckPermissions($_SESSION['pers_id'], $_GET['section']);
	}
	else
	{
		if(in_array($modID, ModulePermissions($_SESSION['pers_id'])))
		{
			$PermLevel = 2;
		}
		else
		{
			$PermLevel = 0;
		}
	}
	
if($PermLevel == 0)
{
	RedirectError($modID);
}
else
{
$SecPerms = SectionPermissions($_SESSION['pers_id'], $modID);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  
  <link rel="stylesheet" type="text/css" href="includes/css/style.css" />
  <title><? echo DEFAULT_PAGE_TITLE; ?></title>
<script language="Javascript" type='text/javascript' src="javascripts/ajax.js"></script>
<script language="Javascript" src="javascripts/CalendarPopup.js"></script>
<script language="Javascript" src="javascripts/AnchorPosition.js"></script>
<script language="Javascript" src="javascripts/date.js"></script>
<script language="Javascript" src="javascripts/PopupWindow.js"></script>
<script language="Javascript" src="javascripts/functions.js"></script>
</head>

<body>
  <div id="wrap">

    <!-- HEADER -->
	  <!-- Background -->
    <div id="header-section">
		  <? include "includes/header.php"; ?>
		</div>

	  <!-- Navigation -->

	  <!-- LEFT COLUMN -->
	  <!-- Navigation -->
    <div id="left-column">
		<? 
		if(isset($_GET['module']))
		{ 
			echo CreateMenu($_SESSION['pers_id'], $_GET['module'], $SecPerms);
		}
		else
		{
			echo CreateMenu($_SESSION['pers_id'], DEFAULT_MOD, $SecPerms);
		}
		?>
    </div>

	  <!-- MIDDLE COLUMN -->
    <div id="middle-column">
	 	<?
		if(isset($_GET['module']))
		{ 
			if(isset($_GET['section']))
			{
				$Section = $_GET['section'];
			}
			else
			{
				$link = mysql_connect(HOST, USER, PASS) or die('Could not connect: ' . mysql_error()); 		//build MySQL Link
				mysql_select_db(DB) or die('Could not select database');		//select database
				$sql = "SELECT section_id FROM T_MOD2SEC 
						WHERE display_order IS NULL
						AND module_id = ".$_GET['module'] . "
						ORDER BY section_id
						LIMIT 1";

				$result = mysql_query($sql) or die(mysql_error());
				$row=mysql_fetch_assoc($result);
				$Section = $row['section_id'];
			}	
				$Path = GetContentInclude($Section, $_GET['module']);
				if(FileExist($Path))
				{
					include($Path);
				}
				else {
					echo "Error: The following file: <b>$Path</b> does not exist!";
				}
		}
		else
		{
			$Path = GetContentInclude(DEFAULT_SEC, DEFAULT_MOD);
			if(FileExist($Path))
			{
				include($Path);
			}
			else {
				echo "Error: The following file: <b>$Path</b> does not exist!";
			}
		}	
		?>
	</div>

	  <!-- FOOTER -->
   <? include "includes/footer.php"; ?>
  </div>
		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
		</script>
		<script type="text/javascript">
		_uacct = "UA-408543-1";
		urchinTracker();
		</script>
</body>
</html>
<?
} //End ELSE block of IF PermLevel was 0
} //End IF block if Session was lost due to change of REMOTE_ADDR
else
{
	logout_user();
}
?>