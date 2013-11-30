<?php

	// Turn off all error reporting
	error_reporting(0);

	/*
	 * Press Kit Installation Script
	 * 
	 * This script will install the Press Kit to your server.
	 * To install this script you will need a FTP program.
	 * Put the install.php file in an empty directory on your server to install.
	 * Put the install.php file in the root folder of a completed installation to upgrade your installation.
	 *
	 */	



	function isEmpty($var)
	{
		if(strlen($var) == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function ftp_is_dir($connection, $dir)
	{
	    $pushd = ftp_pwd($connection);

	    if ($pushd !== false && @ftp_chdir($connection, $dir))
	    {
	        ftp_chdir($connection, $pushd);   
	        return true;
	    }

	    return false;
	}	 



    function dl_r($filename, $remote_url = 'http://www.ramiismail.com/kit/press/' ) {
		$remote_url .=  $filename;
		$local_file = $filename;
	
		if( ini_get('allow_url_fopen') ) {
			copy($remote_url, $local_file);
			return true;
		}
        
        $fp = fopen($local_file, 'w+');
        
        $cp = curl_init();
		curl_setopt($cp, CURLOPT_URL, $remote_url);
		curl_setopt($cp, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($cp, CURLOPT_CONNECTTIMEOUT, 5);
		
        $buffer = curl_exec($cp);
		
		curl_close($cp);
		fwrite($fp, $buffer);
        fclose($fp);
        
        return true;
    }

    // We'll first need to grab the CSS files. Otherwise, this'll look like crap.
	//if( file_exists('style.css') ) unlink('style.css');
	//dl_r('style.css');
	//if( !file_exists('style.css') ) dl_r('style.css', 'http://dl.dropbox.com/u/12157099/presskit/');

	
	if( true )
	{
		session_start();
		

			if (isset($_POST['ftpSubmit']))
			{	
			   $_SESSION['ftp_servername'] = $_POST["ftp_servername"];
			   
			   if(isEmpty($_SESSION['ftp_servername']))
			   {
			   		$serverError="Server Name cannot be empty";
			   }

			   
			   $_SESSION['ftp_username'] = $_POST["ftp_username"];
			   
			   if(isEmpty($_SESSION['ftp_username']))
			   {
			   		$usernameError="Username cannot be empty";
			   }

			   $_SESSION['ftp_password'] = $_POST["ftp_password"];

			   if(isEmpty($_SESSION['ftp_password']))
			   		$passwordError="Password cannot be empty";

			   	$connection = ftp_connect($_SESSION['ftp_servername']);
       			$user = $_SESSION['ftp_username'];
       			$pass = $_SESSION['ftp_password'];

				

			   	if(!ftp_login($connection,$user,$pass))
			   	{
			   		
					   	if(!$connection)
					   	{
					   		$serverError="Server does not exist or could not be connected to";
					   	}
					   	else
					   	{
					   		$serverError="";
					   		$usernameError="Username/Password is incorrect";
					   		$passwordError="Username/Password is incorrect";
					   	}

			   	}
			   	else{

			   		$installing = 1;
			   		$upgrade = 0;
			   		$file_needed = 0;
			   		$contents_on_server = ftp_nlist($connection, ftp_pwd($connection)); 
			   		$path = ftp_pwd($connection);
			   		
			   		if(count(ftp_nlist($connection, $path)) > 3)
			   		{
			   			if(!in_array($path . "validation.js", $contents_on_server))
			   			{

			   			}else{

			   				if(in_array($path . "data.xml", $contents_on_server))
			   				{
			   					$upgrade = 1;
			   				}

			   				if(in_array($path . "_data.xml", $contents_on_server))
			   				{
			   					ftp_rename($connection, "_data.xml", "_data.bak");
			   				}

			   			
			   			}
			   		} 


			   		if(!ftp_is_dir($connection,"images"))
			   			ftp_mkdir($connection,"images");
			   		if(!ftp_is_dir($connection,"trailers"))
			   			ftp_mkdir($connection, "trailers");


			   		// install procedures here

			   		ftp_close($connection);


			   	}
			  
			}
				
		
			echo('<html>');

			if( $upgrade == 0 )
				echo('<head><title>Installation</title><link href="style.css" rel="stylesheet" type="text/css" />');
			else
				echo('<head><title>Upgrade</title><link href="style.css" rel="stylesheet" type="text/css" />');
			
			echo('<div id="navigation"><p><h1 id="game-title">Installation</h1><strong>Press Kit</strong></p></div><div id="content">');
			echo('<h2>Server Environment Check Failed: PHP Safe Mode Enabled</h2>');
			echo('<p>Sadly, you or your host seem to have enabled <b>PHP Safe Mode</b>. PHP Safe Mode results in unexpected behavior with user-installed sripts on your server and might cause presskit() to not function correctly. Please upgrade to PHP 5.4.0 or later or disable Safe Mode to continue.</p>');
			echo('<p>Alternatively, if you do not have the rights to disable PHP Safe Mode, you can use an FTP Connection to complete the installation. </p>');

				echo('<h3>FTP Connection</h3>');
				echo('<form name="ftp" method=POST action=\''.htmlspecialchars($_SERVER['PHP_SELF']).'\'>');
				echo('<p>Server Name: <input type="text" name="ftp_servername" placeholder="ftp.myserver.com" value=\''.(isset($_POST['ftp_servername']) ? $_POST['ftp_servername']: $_SESSION['ftp_servername'] ).'\'></p><span class="error">'. $serverError .'</span>');
				echo('<p>Username: <input type="text" name="ftp_username" placeholder="John Doe" value=\''.(isset($_POST['ftp_username']) ? $_POST['ftp_username']: $_SESSION['ftp_username'] ).'\'></p><span class="error">'. $usernameError .'</span>');
				echo('<p>Password: <input type="password" name="ftp_password" value=\''.(isset($_POST['ftp_password']) ? $_POST['ftp_password']: $_SESSION['ftp_password'] ).'\'></p> <span class="error">'. $passwordError .'</span>');
				echo('<p><input type="submit" name="ftpSubmit" value="Submit" class="submit_button"></p>');
				echo('</form>');

				echo '<html>';

		

		return; 

	}
	
	$upgrade = 0;

	$file_needed = 0;
	if( count( glob( "*.*" ) ) > 3 )
	{
		if( !file_exists('validation.js') )
		{

		}
		else
		{
			if( file_exists('data.xml') )
			{
				$upgrade = 1;
			}
			
			if( file_exists('_data.xml') )
			{
				rename('_data.xml', '_data.bak');
			}
		}
	}

	

	echo('<html>');
	
	if( $upgrade == 0 )
		echo('<head><title>Installation</title><link href="style.css" rel="stylesheet" type="text/css" />');
	else
		echo('<head><title>Upgrade</title><link href="style.css" rel="stylesheet" type="text/css" />');	

	echo('<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>');
	echo('<body><div id="container">');

	if( $upgrade == 0 )
		echo('<div id="navigation"><p><h1 id="game-title">Installation</h1><strong>Press Kit</strong></p></div><div id="content">');
	else
		echo('<div id="navigation"><p><h1 id="game-title">Upgrade</h1><strong>Press Kit</strong></p></div><div id="content">');

	echo('<h2>Progress</h2>');
	echo('<p>Don\'t worry, this should be over before you really notice anything has happened.</p>');
	echo('<ul>');
	echo('<li>Downloading files...</li>');	
	
	dl_r('archive.zip');
	if( !file_exists('archive.zip') ) dl_r('archive.zip', 'http://dl.dropbox.com/u/12157099/presskit/');
	
	echo('<li>Installing files...</li>');	
	
	if( !class_exists("ZipArchive") )
	{
		dl_r('pclzip.lib');
		rename('pclzip.lib','pclzip.lib.php');
		require_once('pclzip.lib.php');
		$archive = new PclZip('archive.zip');
		if ($archive->extract() == 0) 
		{
			die("Error : ".$archive->errorInfo(true));
		}
		unlink('pclzip.lib.php');
	} 
	else 
	{
		$zip = new ZipArchive;
		$res = $zip->open('archive.zip');
		if( $res === TRUE )
		{
			$zip->extractTo('.');
			$zip->close();
		}
	}
	
	
	if( file_exists('_data.bak') )
	{
		rename('_data.bak', '_data.xml');
	}


	if( !is_dir('images') )
	{
		echo('<li>Creating folders...</li>');	
		mkdir('images');
	}
	
	if( !is_dir('trailers') )
		mkdir('trailers');

	echo('<li>Deleting residue and temporary files...</li>');
		unlink('archive.zip');

	echo('</ul>');

	if( $upgrade == 0 )
	{
		echo('<h2>Now comes the fun part!</h2>');
		echo('<p>This was rather easy &amp; painless, wasn\'t it? Well, this is where the automated part ends and where you come in. There\'s about thirty to sixty minutes of work left and said work includes some XML-editing and FTP. By all means take a break and think of what you want to say about your company. I\'ll be right here!</p>');
		echo('<input type="button" value="Let\'s do this!" onClick="$(\'#container\').load(\'create.php?s=installation&p=\'+$(\'#company\').val()); setInterval(function() { $(\'#container\').load(\'create.php?s=installation&p=\'+$(\'#company\').val()) }, 5000);" />');
	}
	else
	{
		if( file_exists('_data.xml') ) unlink('_data.xml');
		echo('<h2>That was all!</h2>');
		echo('<p>Your scripts have been updated! There are a few more things that you need to do before we continue. The next steps should only take a few seconds to complete &amp; as you\'d probably want to minimize the time your press page is unavailable, it\'d be best if you do everything right away.</p>');		
		echo('<input type="button" value="What are we waiting for?!" onClick="$(\'#container\').load(\'create.php?s=upgrade&p=\'+$(\'#company\').val()); setInterval(function() { $(\'#container\').load(\'create.php?s=upgrade&p=\'+$(\'#company\').val()) }, 5000);" />');
	}
	echo('</div>');
	echo('</div>');
	echo('</body></html>');
	
?>