<?php
	$game = $_GET['p'];
	$state = $_GET['s'];
	$checksum = 0;

	if( $state == 'upgrade' )
	{
		if( file_exists('install.php') )
		{
			echo('<div id="navigation"><p><h1 id="game-title">Upgrade</h1><strong><a href="#header" target="_self">Press kit</a></strong></p></div><div id="content">');
			if( file_exists("images/header.png") ) echo('<img src="images/header.png" id="header" width="960" />');
			echo( '<h2>Ready?</h2>');
			echo('<p>Almost done! Just complete this final step and you\'ll be done with the upgrade. I don\'t want to sound forward, but you should know you\'re a better person for keeping your scripts up to date!</p></ul>');

			if( !file_exists('install.php') )
			{
				echo('<li style="color:green"><del>'); $checksum++;
			}
			else echo('<li>');
			echo( 'Rename or remove install.php for security purposes.</del></li>');
			echo('</ul>');		
			die();		
		}
		else
		{
			echo('<div id="navigation"><p><h1 id="game-title">Upgrade</h1><strong><a href="#header" target="_self">Press kit</a></strong></p></div><div id="content">');
			if( file_exists("images/header.png") ) echo('<img src="images/header.png" id="header" width="960" />');
			echo( '<h2>Congratulations, you are ready to show this page to the world!</h2>' );
			echo( '<p>This shouldn\'t have been all that painful, has it? Either way, all that is left now is for you to see the press page in all its glory is one click.</p><p>Just click <a href="index.php">take me there already</a> to see check out your fully patched &amp; upgraded system.</p><p>Don\'t forget that you can always rename the data.xml file back to _data.xml to return to the instructions page.</p>' );
			die();
		}
	}
	
	if( $state == 'installation' )
	{
		// install page
		if( file_exists('data.xml') )
		{
			echo('<div id="navigation"><p><h1 id="game-title">Installation</h1><strong><a href="#header" target="_self">Press kit</a></strong></p></div><div id="content">');
			if( file_exists("images/header.png") ) echo('<img src="images/header.png" id="header" width="960" />');
			echo( '<h2>Congratulations, you are ready to show this page to the world!</h2>' );
			echo( '<p>It took effort, time & persistence (and a few hours of dabbling around in Photoshop), but you can finally say that you are done! All that is left now is for you to see the press page in all its glory is one click.</p><p>Just click <a href="index.php">take me there already</a> to see the fruits of your hard labor.</p><p>Don\'t forget that you can always rename the data.xml file back to _data.xml to return to the instructions page.</p>' );
			die();
		}	
		else if( !file_exists('install.php') )
		{
			echo('<div id="navigation"><p><h1 id="game-title">Installation</h1><strong><a href="#header" target="_self">Press kit</a></strong></p></div><div id="content">');
			echo( '<h2>Before you go... this is how you create new projects.</h2>' );
			echo( '<p>When this is all over, you probably want to add a project or some. Take a look at the files in the _template folder to see how you create a project. To easily create a project, duplicate the _template folder and rename it to the projects name in lowercase, replacing any white spaces with underscores. Imagine you have a project called "Super Crate Box", it would reside in a folder called "super_crate_box".</p>');
			echo( '<h2>Got it! Let\'s rock!</h2>' );
			echo( '<p>When done, <strong>rename the _data.xml file to data.xml (without the underscore)</strong> to finish the page creation. After you\'ve renamed the file, refresh this page.</p>');
			die();
		}
		else
		{
			echo('<div id="navigation"><p><h1 id="game-title">Installation</h1><strong><a href="#header" target="_self">Instructions</a></strong></p></div><div id="content">');
			echo('<h2>Why am I seeing this page?</h2>');
			
			echo( '<p>The installation procedure is almost done, but you\'ll probably need another thirty to sixty minutes to fully complete installation. Don\'t worry - things aren\'t in much of a hurry, you can always close this tab now and return later.</p>');		
			echo( '<p>If you are ready, you will need FTP &amp; XML-editing capabilities. Please complete the following steps to finish the installation.</p>');		
			
			echo('<h2>Required actions</h2>
			<ul>');
			if( file_exists('_data.xml') )
			{
				$file = file('_data.xml', FILE_SKIP_EMPTY_LINES);
				$found = 0;
				foreach( $file as $line_num => $line )
				{
					if( $line_num < 10 )
					{
						$line = htmlspecialchars($line);
						// check for the correct line
						if( strpos($line, '&lt;/title&gt;') > 0 )
						{
							$start = strpos($line, '&lt;title&gt;') + 13;
							$title = substr($line, $start, strlen("Company Name") );
																	
							if( ucwords(str_replace("_", " ", $title) ) != "Company Name" )
							{
								echo('<li style="color:green"><del>');
								$found++;
								$checksum++;
								break;		
							}
						}
					}
				}
				
				if( $found == 0 )
					echo('<li>');			
			}
		}
		echo( 'Edit the _data.xml file that was created in the folder containing install.php &amp; update it with the correct information.</li>');
	
		if( file_exists('images/header.png') )
		{
			echo('<li style="color:green"><del>'); $checksum++;
		}
		else echo('<li>');
		echo( 'Upload header.png (720 pixels wide, up to 240 pixels high) to the images directory.</del></li>');
	
		if( $files = glob("images/*.png") )
		{
			if( count($files) > 0 )
			{
				$found = 0;
				foreach( $files as $file )
				{
					if( substr($file, -10) != "header.png" && substr($file, -8) != "logo.png" && substr($file, -8) != "icon.png" )
					{
						$found++;	
					}
				}
				
				if( $found > 0 )
				{
						echo('<li style="color:green"><del>'); $checksum++;
				}
				else 
					echo('<li>');	
			}	
			else echo('<li>');
		}
		else echo('<li>');
	
		echo( 'Upload appropriate *.png files to the images directory. No further action is required to make the images show up.</li>');
		
		echo('</ul>');
		
		echo('<h2>Optional actions</h2>');
	
		echo('<ul>');
		if( file_exists('images/images.zip') ) echo('<li style="color:green"><del>'); else echo('<li>');	
		echo( '(Optional) Archive all the images and upload the file as images.zip. No further action is required to make the download show up.</li>');
			
		if( file_exists('images/logo.png') || file_exists('images/icon.png') ) echo('<li style="color:green"><del>'); else echo('<li>');		
		echo( '(Optional) Upload logo.png or icon.png.  No further action is required to make the images show up.</li>');
	
		if( file_exists('images/logo.zip') ) echo('<li style="color:green"><del>'); else echo('<li>');	
		echo( '(Optional) Archive the logo, icon and variations on them and upload the file as logo.zip. No further action is required to make the download show up.</li>');
	
		if( count(glob("trailers/*.mov")) + count(glob("trailers/*.mp4")) > 0 ) echo('<li style="color:green"><del>'); else echo('<li>');
		echo( '(Optional) Upload appropriate *.mov or *.mp4 files in the trailers directory. Update _data.xml accordingly for this step, the &lt;mov&gt; and &lt;mp4&gt; tags are needed in the trailer entry for these downloads to show up.</li>');
	
		echo( '</ul>');

		echo('<h2>Additional services</h2>');
		echo('<ul>');
		if( file_exists('_data.xml') )
		{
			$file = file('_data.xml', FILE_SKIP_EMPTY_LINES);
			$found = 0;
			foreach( $file as $line_num => $line )
			{
				$line = htmlspecialchars($line);
				// check for the correct line
				if( strpos($line, '&lt;/analytics&gt;') > 0 )
				{
					$start = strpos($line, '&lt;analytics&gt;') + 17;
					$end = strpos($line, '&lt;/analytics&gt;');
					$analytics = substr($line, $start, $end - $start );
															
					if( strlen($analytics) > 10 )
					{
						echo('<li style="color:green"><del>');
						$found++;
						break;		
					}
				}
			}
				
			if( $found == 0 )
				echo('<li>');			
		}
		echo( '(Optional) Enable <strong><a href="http://analytics.google.com/">Google Analytics</a></strong> to track traffic to your presskit() by adding &lt;analytics&gt;<em>your property id</em>&lt;/analytics&gt; to your _data.xml file.</li>');
		echo('</ul>');
	
		if( file_exists('images/data.xml') )
		{
			echo( '<h2>Ready!</h2>');
			echo( '<p>You are done. Refresh this page to see the result.</p>' );
		}
		else
		{
			if( $checksum >= 3 )
			{
				echo( '<h2>Ready?</h2>');
				echo('<p>Almost done! Just complete this final step and you\'ll be done with all of this. You definitely deserve a nice drink after going through all of this.</p></ul>');

				if( !file_exists('install.php') )
				{
					echo('<li style="color:green"><del>'); $checksum++;
				}
				else echo('<li>');
				echo( 'Rename or remove install.php for security purposes.</del></li>');
				echo('</ul>');				
			}
		}
		
		echo('</div>');		
	}
	else
	{
		// Game page
		if( file_exists($game.'/data.xml') )
		{
			echo('<div id="navigation"><p><h1 id="game-title">'.ucwords(str_replace("_", " ", $game) ).'</h1><strong><a href="#header" target="_self">Press kit</a></strong></p></div><div id="content">');
			if( file_exists($game."/images/header.png") ) echo('<img src="'.$game.'/images/header.png" id="header" width="960" />');
			echo( '<h2>Congratulations, you are ready to show this page to the world!</h2>' );
			echo( '<p>It took effort, time & persistence (and a few hours of dabbling around in Photoshop), but you can finally say that you are done! All that is left now is for you to refresh this page to see the '.ucwords(str_replace("_", " ", $game) ).' page in all its glory.<p>Don\'t forget that you can always rename the data.xml file back to _data.xml to return to the instructions page.</p>' );
			die();
		}	
		else
		{
			echo('<div id="navigation"><p><h1 id="game-title">Incomplete Page</h1><strong><a href="#header" target="_self">Instructions</a></strong></p></div><div id="content">');
			echo('<h2>Why am I seeing this page?</h2>');
			
			echo( '<p>This game has an entry, but the relevant files have not been uploaded yet.</p>');		
			echo( '<p>If you are the webmaster, please note that the appropriate files & directories have been generated for you. Take the following steps to create the press page:</p>');		
			
			echo('<h2>Required actions</h2>
			<ul>');
			if( file_exists($game.'/_data.xml') )
			{
				$file = file($game.'/_data.xml', FILE_SKIP_EMPTY_LINES);
				$found = 0;
				foreach( $file as $line_num => $line )
				{
					$line = htmlspecialchars($line);
					// check for the correct line
					if( strpos($line, '&lt;/title&gt;') > 0 )
					{
						$start = strpos($line, '&lt;title&gt;') + 13;
						$title = substr($line, $start, strlen(ucwords(str_replace("_", " ", $game) ) ) );
																
						if( ucwords(str_replace("_", " ", $title) ) == ucwords(str_replace("_", " ", $game) ) )
						{
							echo('<li style="color:green"><del>');
							$found++;
							$checksum++;
							break;		
						}
					}
				}
				
				if( $found == 0 )
					echo('<li>');			
			}
		}
		echo( 'Check the _data.xml file in the '.$game.' folder and update it with the correct information. The &lt;title&gt; tag should read "'.ucwords(str_replace("_", " ", $game) ).'".</li>');
	
		if( file_exists($game.'/images/header.png') )
		{
			echo('<li style="color:green"><del>'); $checksum++;
		}
		else echo('<li>');
		echo( 'Upload header.png (720 pixels wide, up to 240 pixels high) to the images directory.</del></li>');
	
		if( $files = glob($game . "/images/*.png") )
		{
			if( count($files) > 0 )
			{
				$found = 0;
				foreach( $files as $file )
				{
					if( substr($file, -10) != "header.png" && substr($file, -8) != "logo.png" && substr($file, -8) != "icon.png" )
					{
						$found++;	
					}
				}
				
				if( $found > 0 )
				{
						echo('<li style="color:green"><del>'); $checksum++;
				}
				else 
					echo('<li>');	
			}
			else echo('<li>');			
		}
		else echo('<li>');
		echo( 'Upload appropriate *.png files to the images directory. No further action is required to make the images show up.</li>');
		
		echo('</ul>');
		
		echo('<h2>Optional actions</h2>');
	
		echo('<ul>');
		if( file_exists($game.'/images/images.zip') ) echo('<li style="color:green"><del>'); else echo('<li>');	
		echo( '(Optional) Archive all the images and upload the file as images.zip. No further action is required to make the download show up.</li>');
			
		if( file_exists($game.'/images/logo.png') || file_exists($game.'/images/icon.png') ) echo('<li style="color:green"><del>'); else echo('<li>');		
		echo( '(Optional) Upload logo.png or icon.png.  No further action is required to make the images show up.</li>');
	
		if( file_exists($game.'/images/logo.zip') ) echo('<li style="color:green"><del>'); else echo('<li>');	
		echo( '(Optional) Archive the logo, icon and variations on them and upload the file as logo.zip. No further action is required to make the download show up.</li>');
	
		if( count(glob($game . "/trailers/*.mov")) + count(glob($game . "/trailers/*.mp4")) > 0 ) echo('<li style="color:green"><del>'); else echo('<li>');
		echo( '(Optional) Upload appropriate *.mov or *.mp4 files in the trailers directory. Update _data.xml accordingly for this step, the &lt;mov&gt; and &lt;mp4&gt; tags are needed in the trailer entry for these downloads to show up.</li>');
	
		echo( '</ul>');

		echo('<h2>Additional services</h2>');
		echo('<ul>');
		if( file_exists($game.'/_data.xml') )
		{
			$file = file($game.'/_data.xml', FILE_SKIP_EMPTY_LINES);
			$found = 0;
			foreach( $file as $line_num => $line )
			{
				$line = htmlspecialchars($line);
				// check for the correct line
				if( strpos($line, '&lt;/product&gt;') > 0 )
				{
					$start = strpos($line, '&lt;product&gt;') + 15;
					$end = strpos($line, '&lt;/product&gt;');
					$promoter = substr($line, $start, $end );
															
					if( $promoter != 0 )
					{
						echo('<li style="color:green"><del>');
						$found++;
						break;		
					}
				}
			}
				
			if( $found == 0 )
				echo('<li>');			
		}
		echo( '(Optional) Enable <strong><a href="http://promoterapp.com/">Promoter</a></strong> to automatically list selected awards &amp; reviews by checking the appropriate checkbox in the <a href="http://promoterapp.com/">Promoter</a> settings for your game.</li>');
		echo('</ul>');
		
		if( file_exists($game.'/images/data.xml') )
		{
			echo( '<h2>Ready!</h2>');
			echo( '<p>You are done. Refresh this page to see the result.</p>' );
		}
		else
		{
			if( $checksum >= 3 )
			{
				echo( '<h2>Ready?</h2>');
				echo( '<p>When done, <strong>rename the _data.xml file to data.xml (without the underscore)</strong> to finish the page creation. After you\'ve renamed the file, refresh this page.</p>');
			}
		}
		
		echo('</div>');
	}
?>