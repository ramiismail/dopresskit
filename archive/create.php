<?php

$game = $_GET['p'];
$state = $_GET['s'];
$checksum = 0;
	
$todo = array(
	"required" => array(
		"data.xml" => array(
			"text" => "Edit the _data.xml file that was created in the folder containing install.php &amp; update it with the correct information.",
			"done" => False
		),
		"header.png" => array(
			"text" => "Upload header.png (1200 pixels wide, up to 240 pixels high) to the images directory.",
			"done" => False
		),
		"images" => array(
			"text" => "Upload appropriate *.png files to the images directory. No further action is required to make the images show up.",
			"done" => False
		)
	),
	"optional" => array(
		"images.zip" => array(
			"text" => "(Optional) Archive all the images and upload the file as images.zip. No further action is required to make the download show up.",
			"done" => False
		),
		"logo" => array(
			"text" => "(Optional) Upload logo.png or icon.png.  No further action is required to make the images show up.",
			"done" => False
		),
		"logo.zip" => array(
			"text" => "(Optional) Archive the logo, icon and variations on them and upload the file as logo.zip. No further action is required to make the download show up.",
			"done" => False
		),
		"trailers" => array(
			"text" => "(Optional) Upload appropriate *.mov or *.mp4 files in the trailers directory. Update _data.xml accordingly for this step, the &lt;mov&gt; and &lt;mp4&gt; tags are needed in the trailer entry for these downloads to show up.",
			"done" => False
		)
	),
	"additional" => array(
		"analytics" => array(
			"text" => "(Optional) Enable <strong><a href=\"https://analytics.google.com/\">Google Analytics</a></strong> to track traffic to your presskit() by adding &lt;analytics&gt;<em>your property id</em>&lt;/analytics&gt; to your _data.xml file.",
			"done" => False
		)
	)
);

$navTitle = '';
$header = '';
$contentText = '';

if( file_exists("images/header.png") )
{
	$header = '<img src="images/header.png" class="header">';
}

if( $state == 'upgrade' )
{
	$navTitle = 'Upgrade';

	if( file_exists('install.php') )
	{
		$contentText = '<h2>Ready?</h2>
<p>Almost done! Just complete this final step and you\'ll be done with the upgrade. I don\'t want to sound forward, but you should know you\'re a better person for keeping your scripts up to date!</p>';

		// Recreate the todo array for the "remove instal.php" notice
		unset($todo);
		$todo = array(
			"finish" => array(
				"install.php" => array(
					"text" => "Rename or remove install.php for security purposes.",
					"done" => False
				)
			)
		);
	} else {
		// There are no tasks left to do so we'll empty the array
		unset($todo);
		$todo = array();

		$contentText = '<h2>Congratulations, you are ready to show this page to the world!</h2>
<p>This shouldn\'t have been all that painful, has it? Either way, all that is left now is for you to see the press page in all its glory is one click.</p>
<p>Just click <a href="index.php">take me there already</a> to see check out your fully patched &amp; upgraded system.</p>
<p>Don\'t forget that you can always rename the data.xml file back to _data.xml to return to the instructions page.</p>';
	}
} else if( $state == 'installation' ) {
	$navTitle = 'Installation';

	if( file_exists('data.xml') )
	{
		$contentText = '<h2>Congratulations, you are ready to show this page to the world!</h2>
<p>It took effort, time & persistence (and a few hours of dabbling around in Photoshop), but you can finally say that you are done! All that is left now is for you to see the press page in all its glory is one click.</p>
<p>Just click <a href="index.php">take me there already</a> to see the fruits of your hard labor.</p><p>Don\'t forget that you can always rename the data.xml file back to _data.xml to return to the instructions page.</p>';

		// There are no tasks left to do so we'll empty the array
		unset($todo);
		$todo = array();
	} else if( !file_exists('install.php') ) {
		$contentText = '<h2>Before you go... this is how you create new projects.</h2>
<p>When this is all over, you probably want to add a project or some. Take a look at the files in the _template folder to see how you create a project. To easily create a project, duplicate the _template folder and rename it to the projects name in lowercase, replacing any white spaces with underscores. Imagine you have a project called "Super Crate Box", it would reside in a folder called "super_crate_box".</p>
<h2>Got it! Let\'s rock!</h2>
<p>When done, <strong>rename the _data.xml file to data.xml (without the underscore)</strong> to finish the page creation. After you\'ve renamed the file, refresh this page.</p>';

		// There are no tasks left to do so we'll empty the array
		unset($todo);
		$todo = array();
	} else {
		$contentText = '<h2>Why am I seeing this page?</h2>
<p>The installation procedure is almost done, but you\'ll probably need another thirty to sixty minutes to fully complete installation. Don\'t worry - things aren\'t in much of a hurry, you can always close this tab now and return later.</p>		
<p>If you are ready, you will need FTP &amp; XML-editing capabilities. Please complete the following steps to finish the installation.</p>';

		if( file_exists('_data.xml') )
		{
			$file = file('_data.xml', FILE_SKIP_EMPTY_LINES);
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
							$todo['required']['data.xml']['done'] = True;
							break;		
						}
					}
				}
			}
		}

		if( file_exists('images/header.png') )
		{
			$todo['required']['header.png']['done'] = True;
		}

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
					$todo['required']['images']['done'] = True;
				}
			}	
		}

		if( file_exists('images/images.zip') )
		{
			$todo['optional']['images.zip']['done'] = True;
		}

		if( file_exists('images/logo.png') || file_exists('images/icon.png') )
		{
			$todo['optional']['logo']['done'] = True;
		}

		if( file_exists('images/logo.zip') )
		{
			$todo['optional']['logo.zip']['done'] = True;
		}

		if( count(glob("trailers/*.mov")) + count(glob("trailers/*.mp4")) > 0 )
		{
			$todo['optional']['trailers']['done'] = True;
		}

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
			{
				$todo['additional']['analytics']['done'] = True;
			}
		}

		if ( $todo['required']['data.xml']['done'] === True && $todo['required']['header.png']['done'] === True && $todo['required']['images']['done'] === True)
		{
			$contentText = '<h2>Ready?</h2>
<p>Almost done! Just complete this final step and you\'ll be done with all of this. You definitely deserve a nice drink after going through all of this.</p>';

			$todo['finish'] = array(
				'install.php' => array(
					'text' => 'Rename or remove install.php for security purposes.',
					'done' => False
				)
			);
		}
	}
} else {
	if( file_exists($game.'/data.xml') )
	{
		unset($todo['additional']['analytics']);
		$todo['additional']['promoter'] = array(
			"text" => "(Optional) Enable <strong><a href=\"https://promoterapp.com/\">Promoter</a></strong> to automatically list selected awards &amp; reviews by checking the appropriate checkbox in the <a href=\"https://promoterapp.com/\">Promoter</a> settings for your game.",
			"done" => False
		);

		$navTitle = ucwords(str_replace("_", " ", $game));

		$contentText = '<h2>Congratulations, you are ready to show this page to the world!</h2>
<p>It took effort, time & persistence (and a few hours of dabbling around in Photoshop), but you can finally say that you are done! All that is left now is for you to refresh this page to see the '.ucwords(str_replace("_", " ", $game) ).' page in all its glory.<p>
Don\'t forget that you can always rename the data.xml file back to _data.xml to return to the instructions page.</p>';

		// There are no tasks left to do so we'll empty the array
		unset($todo);
		$todo = array();
	} else {
		$contentText = '<h2>Why am I seeing this page?</h2>
<p>This game has an entry, but the relevant files have not been uploaded yet.</p>		
<p>If you are the webmaster, please note that the appropriate files & directories have been generated for you. Take the following steps to create the press page:</p>';

		if( file_exists('_data.xml') )
		{
			$file = file($game.'/_data.xml', FILE_SKIP_EMPTY_LINES);
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
						$todo['required']['data.xml']['done'] = True;
						break;		
					}
				}
			}
		}

		if( file_exists('images/header.png') )
		{
			$todo['required']['header.png']['done'] = True;
		}

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
					$todo['required']['images']['done'] = True;
				}
			}	
		}

		if( file_exists('images/images.zip') )
		{
			$todo['optional']['images.zip']['done'] = True;
		}

		if( file_exists('images/logo.png') || file_exists('images/icon.png') )
		{
			$todo['optional']['logo']['done'] = True;
		}

		if( file_exists('images/logo.zip') )
		{
			$todo['optional']['logo.zip']['done'] = True;
		}

		if( count(glob("trailers/*.mov")) + count(glob("trailers/*.mp4")) > 0 )
		{
			$todo['optional']['trailers']['done'] = True;
		}

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
						$todo['optional']['promoter']['done'] = True;
						break;		
					}
				}
			}
		}

		if( file_exists($game.'/images/data.xml') )
		{
			$contentText = '<h2>Ready!</h2>
<p>You are done. Refresh this page to see the result.</p>';
		} else if ( $todo['required']['data.xml']['done'] === True && $todo['required']['header.png']['done'] === True && $todo['required']['images']['done'] === True)
		{
			$contentText = '<h2>Ready?</h2>
<p>When done, <strong>rename the _data.xml file to data.xml (without the underscore)</strong> to finish the page creation. After you\'ve renamed the file, refresh this page.</p>';

			$todo['finish'] = array(
				'install.php' => array(
					'text' => 'Rename or remove install.php for security purposes.',
					'done' => False
				)
			);
		}
	}
}

echo '<div id="navigation" class="uk-width-medium-1-4">
	<h1 id="game-title">' . $navTitle . '</h1>
	<p><strong><a href="#header">Press kit</a></strong></p>
</div>
<div id="content" class="uk-width-medium-3-4">';
echo $header;
echo $contentText;

if ( isset($todo['finish']) )
{
	echo '<h2>Finish the installation</h2>
<ul>';
	foreach ($todo['finish'] as $item)
	{
		if ($item['done'] === True)
		{
			echo '<li class="done">';
		} else {
			echo '<li>';
		}

		echo $item['text'];
		echo '</li>';
	}
	echo '</ul>';
}

if ( isset($todo['required']) )
{
	echo '<h2>Required actions</h2>
<ul>';
	foreach ($todo['required'] as $item)
	{
		if ($item['done'] === True)
		{
			echo '<li class="done">';
		} else {
			echo '<li>';
		}

		echo $item['text'];
		echo '</li>';
	}
	echo '</ul>';
}

if ( isset($todo['optional']) )
{
	echo '<h2>Optional actions</h2>
<ul>';
	foreach ($todo['optional'] as $item)
	{
		if ($item['done'] === True)
		{
			echo '<li class="done">';
		} else {
			echo '<li>';
		}

		echo $item['text'];
		echo '</li>';
	}
	echo '</ul>';
}

if ( isset($todo['additional']) )
{
	echo '<h2>Additional services</h2>
<ul>';
	foreach ($todo['additional'] as $item)
	{
		if ($item['done'] === True)
		{
			echo '<li class="done">';
		} else {
			echo '<li>';
		}

		echo $item['text'];
		echo '</li>';
	}
	echo '</ul>';
}

echo '</div>';

?>
