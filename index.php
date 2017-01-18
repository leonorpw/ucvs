<!DOCTYPE html>
<?php
	/***************************************/
	/* UCVS - Unified Callback Vote Script */
	/*		Written by LemoniscooL		   */
	/*	 released under GPLv3 license	   */
	/***************************************/
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	
	define("UCVS", 1);
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>UCVS - Unified Callback Vote Script</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" />
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<div id="header">
			<img class="logo" src="images/logo.png"/>
		</div>
		
		<?php
		if(!file_exists("./classes/userconfig.class.php") || (isset($_GET['do']) && $_GET['do'] == 'install'))
		{
			include_once("install.php");
		}
		else
		{
		?>
			<div id="content">
				<?php
					if(file_exists("install.php"))
					{
						?>
						<div class="alert alert-error fade in">
							<strong>Warning!</strong><br> The install.php is still existing, for security reasons you should delete it!
						</div>
						<?php
					}
					
					$url = "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."ucvs_listener.php";
					$url = str_replace("index.php", "", $url);
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
		<?php } ?>
	</body>
	<script type="text/javascript" src="js/custom.js"></script>
</html>