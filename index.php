<!DOCTYPE html>
<?php
	/***************************************/
	/* UCVS - Unified Callback Vote Script */
	/*		Written by LemoniscooL		   */
	/*	 released under GPLv3 license	   */
	/***************************************/
	require_once "classes/config.class.php";
	$config = new ucvsConfig();
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>UCVS - Unified Callback Vote Script</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div id="header">
			<img class="logo" src="images/logo.png"/>
		</div>
		
		<? if(file_exists("./classes/userconfig.class.php")) { ?>
			<div id="content">
				<?
					if(file_exists("./install/install.php"))
					{
						?>
						<div class="alert alert-error fade in">
							<strong>Warning!</strong><br> The install folder is still existing, for security reasons you should delete it!
						</div>
						<?
					}
					
					$url = "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."ucvs_listener.php";
				?>
				<h2>Welcome to UCVS - Unified Callback Vote Script</h2>
				<div class="divider"><span></span></div>
				<p>
					Thanks for using our script!<br />
					UCVS was successfully installed and is ready to be used!<br />
					In order to do so just set the callback URL settings on the toplists to: <br />
					<br />
					<pre><?= $url ?></pre><br />
					<br />
					If you need any help feel free to contact us via mail: contact@silkroad-servers.com<br />
					<br />
					Best regards,<br />
					Silkroad-Servers.com Team
				</p>
			</div>
		<? } else { include_once("./install/install.php"); } ?>
	</body>
</html>