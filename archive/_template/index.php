<?php

$game = $_GET['p'];

$xml = simplexml_load_file("data.xml");

foreach( $xml->children() as $child )
{
	switch( $child->getName() )
	{
		case("title"):
			define(GAME_TITLE, $child);
			break;	
		case("release-date"):
			define(GAME_DATE, $child);
			break;
		case("website"):
			define(GAME_WEBSITE, $child);
			break;
		case("platforms"):
			$platforms = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$platforms[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
		case("prices"):
			$prices = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$prices[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
		case("description"):
			define(GAME_DESCRIPTION, $child);
			break;
		case("history"):
			define(GAME_HISTORY, $child);
			break;
		case("features"):
			$features = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$features[$i] = $subchild;
				$i++;
			}
			break;	
		case("trailers"):
			$trailers = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$trailers[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;					
		case("awards"):
			$awards = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$awards[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;					
		case("quotes"):
			$quotes = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$quotes[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;					
		case("additionals"):
			$additionals = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$additionals[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;					
		case("credits"):
			$credits = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$credits[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;					
	}
}

function parseLink($uri)
{
	$parsed = trim($uri);
	if( strpos($parsed, "http://") === 0 )
		$parsed = substr($parsed, 7);
	if (strpos($parsed, "https://") === 0 )
		$parsed = substr($parsed, 8);
	if( strpos($parsed, "www.") === 0 )
		$parsed = substr($parsed, 4);
	if( strrpos($parsed, "/") === strlen($parsed) - 1)
		$parsed = substr($parsed, 0, strlen($parsed) - 1);
	return $parsed;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vlambeer Presskit - <?php echo(GAME_TITLE) ?></title>
<link href="style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="validation.js"></script>
<script>
	$(window).scroll( function() {
		checkVis("factsheet");
		checkVis("description");
		checkVis("history");
		checkVis("features");
		checkVis("trailers");
		checkVis("screenshots");
		checkVis("logo");
		checkVis("awards");
		checkVis("quotes");
		checkVis("preview");
		checkVis("links");
		checkVis("about");
		checkVis("credits");
		checkVis("contact");
	} );

	function checkVis(elem)
	{
		if( isVis( "#"+elem ) ) $("#m-"+elem).css("color","#000"); else $("#m-"+elem).css("color","#666");
	}

	function isVis(elem)
	{
		var docViewTop = $(window).scrollTop();
		var docViewBottom = docViewTop + $(window).height();
	
		var elemTop = $(elem).offset().top;
		var elemBottom = elemTop + $(elem).height();
	
		return ( (elemBottom >= docViewTop && elemBottom <= docViewBottom) || (elemTop <= docViewBottom && elemTop >= docViewTop) || (elemTop <= docViewTop && elemBottom >= docViewBottom) );
	}
</script>

<base target="_blank" />

</head>

<body>

<!-- Page start -->
<div id="container">

    <!-- Navigation start -->
    <div id="navigation">
        <p><h1 id="game-title"><?php echo(GAME_TITLE) ?></h1>
        <strong><a href="#header">Press kit</a></strong></p>
        <br/>
        <ul>
            <li><a href="#factsheet" id="m-factsheet" target="_self">Factsheet</a></li>
            <li><a href="#description" id="m-description" target="_self">Description</a></li>
            <li><a href="#history" id="m-history" target="_self">History</a></li>
            <li><a href="#features" id="m-features" target="_self">Features</a></li>
            <li><a href="#trailers" id="m-trailers" target="_self">Videos</a></li>
            <li><a href="#screenshots" id="m-screenshots" target="_self">Screenshots</a></li>
            <li><a href="#logo" id="m-logo" target="_self">Logo & Icon</a></li>
            <li><a href="#awards" id="m-awards" target="_self">Awards & Recognition</a></li>
            <li><a href="#quotes" id="m-quotes" target="_self">Selected Articles</a></li>
            <li><a href="#preview" id="m-preview" target="_self">Request Press Copy</a></li>
            <li><a href="#links" id="m-links" target="_self">Additional Links</a></li>
            <li><a href="#about" id="m-about" target="_self">About Vlambeer</a></li>
            <li><a href="#credits" id="m-credits" target="_self">Game Credits</a></li>
            <li><a href="#contact" id="m-contact" target="_self">Contact</a></li>
        </ul>
    </div>
    
    <div id="content">
        <!-- Header -->
        <?php 
			if( file_exists("images/header.png") ) echo('<img src="images/header.png" id="header" width="960" />');
		?>
    
        <!-- Factsheet start -->
        <div id="factsheet">
        <h2>Factsheet</h2>
        
        <!-- Developer information -->
        <p><strong>Developer:</strong><br/>
        <a href="">Vlambeer</a><br/>
        Based in Utrecht, Netherlands<br/></p>
        
        <!-- Release date -->
        <p><strong>Release date:</strong><br/>
        <?php echo(GAME_DATE) ?><br/></p>
        
        <!-- Platforms -->
        <p><strong>Platforms:</strong><br/>
        <?php 
			for( $i = 0; $i < count($platforms); $i++ )
			{
				foreach( $platforms[$i]['platform']->children() as $child )
				{
					if( $child->getName() == "name" ) $name = $child;
					else if( $child->getName() == "link" ) $link = $child;
				}
				echo( '<a href="http://www.'.parseLink($link).'/">'.$name.'</a><br/>' );
			}
		?>
        </p>
        
        <!-- Website -->
        <p><strong>Website:</strong><br/>
        <a href="<?php echo(GAME_WEBSITE) ?>"><?php echo parseLink(GAME_WEBSITE) ?></a><br/></p>
        
        <!-- Pricing -->
        <p><strong>Regular Price:</strong><br/>
        <table>
        <?php
			for( $i = 0; $i < count($prices); $i++ )
			{
				foreach( $prices[$i]['price']->children() as $child )
				{
					if( $child->getName() == "currency" ) $currency = $child;
					else if( $child->getName() == "value" ) $value = $child;
				}
				echo( '<tr><td>'.$currency.'</td><td>'.$value.'</td></tr>' );
			}
		?>
        </table>
        </p>
        </div>
        
        <!-- Description start -->
        <div id="description">
        <h2>Description</h2>
        <?php echo(GAME_DESCRIPTION) ?>
        </div>
        
        <!-- History start -->
        <div id="history">
        <h2>History</h2>
        <?php echo(GAME_HISTORY) ?>
        </div>
        
        <!-- Features start -->
        <div id="features">
        <h2>Features</h2>
        <ul>
        <?php
			for( $i = 0; $i < count($features); $i++ )
			{
				echo('<li>'.$features[$i].'</li>');
			}
		?>
        </ul>
        </div>

		<!-- Clear -->
        <div class="clear" />
        
        <!-- Trailers start -->
        <div id="trailers">
		<h2>Videos</h2>
        <?php
			for( $i = 0; $i < count($trailers); $i++ )
			{
				foreach( $trailers[$i]['trailer']->children() as $child )
				{
					if( $child->getName() == "name" ) $name = $child;
					else if( $child->getName() == "youtube" ) $youtube = $child;
					else if( $child->getName() == "vimeo" ) $vimeo = $child;
					else if( $child->getName() == "mov" ) $mov = $child;
					else if( $child->getName() == "mp4" ) $mp4 = $child;
				}
				
				if( strlen($youtube) + strlen($vimeo) > 0 )				
				{
					echo('<p><strong>'.$name.'</strong> ');
					$result = "";
					if( strlen( $youtube ) > 0 ) $result .= '<a href="http://www.youtube.com/?v='.$youtube.'">YouTube</a>, ';
					if( strlen( $vimeo ) > 0 ) $result .= '<a href="http://www.vimeo.com/'.$vimeo.'">Vimeo</a>, ';
					if( strlen( $mov ) > 0 ) $result .= '<a href="trailers/'.$mov.'">.mov</a>, ';
					if( strlen( $mp4 ) > 0 ) $result .= '<a href="trailers/'.$mp4.'">.mp4</a>, ';
					echo( substr($result, 0, -2) );

					if( strlen( $youtube ) > 0 ) 
					{
						echo('<iframe width="720" height="396" src="http://www.youtube.com/embed/'.$youtube.'" frameborder="0" allowfullscreen></iframe>');
					}
					else
					{
						echo('<iframe src="http://player.vimeo.com/video/'.$vimeo.'" width="720" height="540" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');
					}
				}
				else
				{
					echo('<p>There are currently no trailers available for '.GAME_TITLE.'. Check back later for more or <a href="#contact">contact us</a> for specific requests!</p>');					
				}
				echo('</p>');
			}
		?>
        </div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Screenshots start -->
        <div id="screenshots">
        <h2>Screenshots</h2>
        <?php
		
			if( file_exists("images/images.zip") )
			{
				$filesize = filesize("images/images.zip");
				if( $filesize > 1024 && $filesize < 1048576 ) $filesize = (int)( $filesize / 1024 ).'KB';
				if( $filesize > 1048576 ) $filesize = (int)( $filesize / 1024 ).'MB';
				
				echo('<a href="images/images.zip"><div id="media-download">download all screenshots, icons & logos as .zip ('. $filesize .')</div></a>');	
			}
		
			if ($handle = opendir('images')) {
				
				$found = 0;
				/* This is the correct way to loop over the directory. */
				while (false !== ($entry = readdir($handle))) {
					if( substr($entry,-4) == ".png" )
						if( substr($entry,0,4) != "logo" && substr($entry,0,4) != "icon" && substr($entry,0,6) != "header" )
						{	
							echo('<a href="images/'.$entry.'"><img class="preview" src="images/'.$entry.'" alt="'.$entry.'" /></a>');
							$found++;
						}
				}
				
				if( $found == 0 ) echo('<p>There are currently no screenshots available for '.GAME_TITLE.'. Check back later for more or <a href="#contact">contact us</a> for specific requests!</p>');
			}
			
			closedir($handle);
		?>        
        </div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Logo start -->
        <div id="logo">
        <h2>Logo & Icon</h2>
        <?php
        	if( file_exists('images/logo.png') ) echo( '<a href="images/logo.png"><img src="images/logo.png" alt="logo" /></a>' );
        	if( file_exists('images/icon.png') ) echo( '<a href="images/icon.png"><img src="images/icon.png" alt="logo" /></a>' );
			if( !file_exists('images/logo.png') && !file_exists('images/icon.png'))
			echo('<p>There are currently no logos or icons available for '.GAME_TITLE.'. Check back later for more or <a href="#contact">contact us</a> for specific requests!</p>');
		?>
        </div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Award start -->
        <div id="awards">
        <h2>Awards & Recognition</h2>
        <ul>
        <?php 
			for( $i = 0; $i < count($awards); $i++ )
			{
				foreach( $awards[$i]['award']->children() as $child )
				{
					if( $child->getName() == "description" ) $description = $child;
					else if( $child->getName() == "info" ) $info = $child;
				}
				echo( '<li>"'.$description.'" <cite>'.$info.'</cite></li>' );
			}
		?>
        </ul>
        </div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Quote start -->
        <div id="quotes">
        <h2>Selected Articles</h2>
        <ul>
        <?php 
			for( $i = 0; $i < count($quotes); $i++ )
			{
				foreach( $quotes[$i]['quote']->children() as $child )
				{
					if( $child->getName() == "description" ) $description = $child;
					else if( $child->getName() == "name" ) $name = $child;
					else if( $child->getName() == "website" ) $website = $child;
					else if( $child->getName() == "link" ) $link = $child;
				}
				echo( '<li>"'.$description.'" <br/>
				<cite>- '.$name.', <a href="http://www.'.parseLink($link).'/">'.$website.'</a></cite></li>' );
			}
		?>
        </ul>
        </div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Request Preview Copy -->
        <div id="preview">
        <h2>Request Press Copy</h2>
        <p>Please fill in your e-mail address below and we'll get back to you as soon as a press copy is available for you.<br/>
        <div id="mailform"><input type="text" value="me@website.com" id="from" /><input type="button" id="submit-button" value="Request Press Copy" /><br/>&nbsp;<br/>Alternatively, you can always request a press copy by <a href="#contact">sending us a quick email</a>.</div>
        <div id="mailsuccess" style="display:none;">Thanks for the request. We'll be in touch as soon as possible. In the meanwhile, feel free to <a href="#contact">follow up with any questions or requests you might have!</a></div>
        </p></div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Links -->
        <div id="links">
        <h2>Additional Links</h2>
        <?php 
			for( $i = 0; $i < count($additionals); $i++ )
			{
				foreach( $additionals[$i]['additional']->children() as $child )
				{
					if( $child->getName() == "title" ) $title = $child;
					else if( $child->getName() == "description" ) $description = $child;
					else if( $child->getName() == "link" ) $link = $child;
				}
				
				echo('<p><strong>'.$title.'</strong><br/>'.$description.' <a href="http://'.parseLink($link).'/" alt="'.parseLink($link).'">'.substr(parseLink($link),0,strpos(parseLink($link), "/")).'</a>.</p>');
			}
		?>
        </div>
        
		<!-- Clear -->
        <div class="clear" />

		<!-- About -->
        <div id="about">
        <h2>About Vlambeer</h2>
        <p><strong>Boilerplate</strong><br/>
        Vlambeer is a Dutch independent game studio made up of Rami Ismail and Jan Willem Nijman, bringing back arcade games since 1976. Vlambeer is best known for Super Crate Box, Radical Fishing, Serious Sam: The Random Encounter and GUN GODZ, even though they've released quite a few more games and experiments since their founding in September 2010.</p>
        
        <p><strong>More information</strong><br/>
        More information on Vlambeer, our logo & relevant media are available <a href="">here</a>.</p>
        </div>
        
		<!-- Clear -->
        <div class="clear" />
        
        <!-- Credits -->
        <div id="credits">
        <h2><?php echo( GAME_TITLE ) ?> Credits</h2>
        <?php 
			for( $i = 0; $i < count($credits); $i++ )
			{
				$previous = "";
				$website = "";
				foreach( $credits[$i]['credit']->children() as $child )
				{
					if( $child->getName() == "person" ) $person = $child;
					else if( $child->getName() == "previous" ) $previous = $child;
					else if( $child->getName() == "website" ) $website = $child;
					else if( $child->getName() == "role" ) $role = $child;
				}
				
				if( strlen($website) == 0 )
				{
					echo('<p><strong>'.$person.'</strong><br/>'.$role);
				}
				else
				{
					echo('<p><strong>'.$person.'</strong><br/><a href="http://'.parseLink($website).'/">'.$role.'</a>');					
				}
								
				echo('</p>');
			}
		?>
        </div>
        
        <!-- Contact -->
        <div id="contact">
        <h2>Contact</h2>
        <p><strong>Inquiries</strong><br/>
        <a href="mailto:rami@vlambeer.com">rami@vlambeer.com</a></p>
        <p><strong>Twitter</strong><br/>
        <a href="http://www.twitter.com/Vlambeer">twitter.com/Vlambeer</a></p>
        <p><strong>Facebook</strong><br/>
        <a href="http://www.facebook.com/Vlambeer">facebook.com/Vlambeer</a></p>
        <p><strong>Web</strong><br/>
        <a href="http://www.vlambeer.com/">vlambeer.com</a></p>
        </div>

		<!-- Clear -->
        <div class="clear" />

		<p class="credits">press kit template by Rami Ismail (<a href="http://www.vlambeer.com/">Vlambeer</a>) & inspired by Andreas Zecher (<a href="http://www.madebypixelate.com/">madebypixelate</a>)</p>

    </div>
</div>

</body>
</html>
