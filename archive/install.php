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
	if( file_exists('validation.js') )
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
if( file_exists('style.css') )
{
	unlink('style.css');
}

dl_r('style.css');

if( !file_exists('style.css') )
{
	dl_r('style.css', 'http://dl.dropbox.com/u/12157099/presskit/');
}

if ($upgrade == 0)
{
	$title = 'Installation';
} else {
	$title = 'Upgrade';
}

dl_r('archive.zip');

if( !file_exists('archive.zip') )
{
	dl_r('archive.zip', 'http://dl.dropbox.com/u/12157099/presskit/');
}
	
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
	$directoriesText = '<li>Creating folders...</li>';
	mkdir('images');
} else {
	$directoriesText = '';
}
	
if( !is_dir('trailers') )
{
	mkdir('trailers');
}

unlink('archive.zip');

if( $upgrade == 0 )
{
	$doneText = '<h2>Now comes the fun part!</h2>
<p>This was rather easy &amp; painless, wasn\'t it? Well, this is where the automated part ends and where you come in. There\'s about thirty to sixty minutes of work left and said work includes some XML-editing and FTP. By all means take a break and think of what you want to say about your company. I\'ll be right here!</p>
<button class=\'uk-button uk-button-primary loadInstall\'>Let\'s do this!</button>';
}
else
{
	if( file_exists('_data.xml') )
	{
		unlink('_data.xml');
	}

	$doneText = '<h2>That was all!</h2>
<p>Your scripts have been updated! There are a few more things that you need to do before we continue. The next steps should only take a few seconds to complete &amp; as you\'d probably want to minimize the time your press page is unavailable, it\'d be best if you do everything right away.</p>
<button class=\'uk-button uk-button-primary loadUpgrade\'>What are we waiting for?!</button>';
}

echo '<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>' . $title . '</title>
		<link href="http://cdnjs.cloudflare.com/ajax/libs/uikit/1.2.0/css/uikit.gradient.min.css" rel="stylesheet" type="text/css">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div class="uk-container uk-container-center">
			<div class="uk-grid">
				<div id="navigation" class="uk-width-medium-1-4">
					<h1 id="game-title">' . $title . '</h1>
					<p><strong>Press Kit</strong></p>
				</div>
				<div id="content" class="uk-width-medium-3-4">
					<h2>Progress</h2>
					<p>Don\'t worry, this should be over before you really notice anything has happened.</p>
					<ul>
						<li>Downloading files...</li>
						<li>Installing files...</li>
						' . $directoriesText . '
						<li>Deleting residue and temporary files...</li>
					</ul>
					' . $doneText . '
				</div>
			</div>
		</div>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript">
			$(function() {
				var updateContent = function(type) {
					var company = $("#company").val();
					$(".uk-grid").load("create.php?s=" + type + "&p=" + company);

					setInterval(function() {
						$(".uk-grid").load("create.php?s=" + type + "&p=" + company);
					}, 5000);
				}

				$(".loadInstall").click(function() {
					updateContent("installation");
				});

				$(".loadUpgrade").click(function() {
					updateContent("upgrade");
				});
			});
		</script>
	</body>
</html>';
