<?php
	/*
	 * Press Kit Installation Script
	 * 
	 * This script will install the Press Kit to your server.
	 * To install this script you will need a FTP program.
	 * Put the install.php file in an empty directory on your server to install.
	 * Put the install.php file in the root folder of a completed installation to upgrade your installation.
	 *
	 */	

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
	
	if( ini_get('safe_mode') )
	{
		echo('<h1>Server Environment Check Failed: PHP Safe Mode Enabled</h1><p>Sadly, you or your host seem to have enabled PHP Safe Mode. PHP Safe Mode results in unexpected behaviour with user-installed scripts on your server and might cause presskit() to not function correctly. Please upgrade to PHP 5.4.0 or later or disable Safe Mode to continue.</p><p>If you cannot disable Safe Mode nor upgrade and are comfortable installing scripts, please download the <a href="http://ramiismail.com/kit/press/manual-install.zip">manual installation package</a>.</p>');
		die();
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

	// We'll first need to grab the CSS files. Otherwise, this'll look like crap.
	if( file_exists('style.css') ) unlink('style.css');
	dl_r('style.css');
	if( !file_exists('style.css') ) dl_r('style.css', 'http://dl.dropbox.com/u/12157099/presskit/');

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