<?php
if( file_exists('install.php') )
{
	include('install.php');
	die();
}

$game = $_GET['p'];
if( !file_exists( $game.'/data.xml' ) )
{
	if( $game == "credits" )
	{
		echo('<html>');
		echo('<head><title>Thanks!</title><link href="style.css" rel="stylesheet" type="text/css" />');
		echo('<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>');
		echo('<body><div id="container"></div>');
		echo('<script>$("#container").load("credits.php");</script>');
		echo('</body></html>');
		die();		
	}
	else if( is_dir($game ) && $game != "images" && $game != "trailers" && $game != "_template" )
	{
		echo('<html>');
		echo('<head><title>Instructions</title><link href="style.css" rel="stylesheet" type="text/css" />');
		echo('<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>');
		echo('<body><div id="container"></div>');
		echo('<script>$("#container").load("create.php?p='.$game.'"); setInterval( function() { $("#container").load("create.php?p='.$game.'") }, 5000 )</script>');
		echo('</body></html>');
		if( !is_dir($game.'/images') ) mkdir($game.'/images');
		if( !is_dir($game.'/trailers') ) mkdir($game.'/trailers');
		if( !file_exists($game.'/_data.xml') ) copy('_template/_data.xml',$game.'/_data.xml');
		die();
	}
	else
	{
		include('index.php');	
		die();
	}
}

$press_request = TRUE;
$xml = simplexml_load_file($game."/data.xml");

foreach( $xml->children() as $child )
{
	switch( $child->getName() )
	{
		case("title"):
			define("GAME_TITLE", $child);
			break;	
		case("release-date"):
			define("GAME_DATE", $child);
			break;
		case("website"):
			define("GAME_WEBSITE", $child);
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
			define("GAME_DESCRIPTION", $child);
			break;
		case("history"):
			define("GAME_HISTORY", $child);
			break;
		case("histories"):
			$histories = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$histories[$i][$subchild->getName()] = $subchild;
				$i++;
			}
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
		case("press-can-request-copy"):
			if( strtolower($child) == "false" ) $press_request = FALSE;
			else $press_request = TRUE;
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
		case("promoter"):
			$promoterawards = array();
			$promoterquotes = array();

			$promotercode = ($child->children());
			$promotercode = $promotercode->product;
			
			$promoterxml = simplexml_load_file('http://promoterapp.com/dopresskit/'.$promotercode);
			
			foreach( $promoterxml->children() as $promoterchild )
			{
				switch( $promoterchild->children()->getName() )
				{
					case("review"):
						$i = 0;
						foreach( $promoterchild->children() as $promotersubchild )
						{
							$promoterquotes[$i][$promotersubchild->getName()] = $promotersubchild;
							$i++;
						}					
						break;
					case("award"):
						$i = 0;
						foreach( $promoterchild->children() as $promotersubchild )
						{
							$promoterawards[$i][$promotersubchild->getName()] = $promotersubchild;
							$i++;
						}					
						break;							
				}
			}
			
			break;
	}
}

$xml = simplexml_load_file("data.xml");

foreach( $xml->children() as $child )
{
	switch( $child->getName() )
	{
		case("title"):
			define("COMPANY_TITLE", $child);
			break;	
		case("based-in"):
			define("COMPANY_BASED", $child);
			break;
		case("description"):
			define("COMPANY_DESCRIPTION", $child);
			break;
		case("analytics"):
			define("ANALYTICS", $child);
			break;
		case("contacts"):
			$contacts = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$contacts[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;					
	}
}

function parseLink($uri)
{
	$parsed = $uri;
	if( strpos($parsed, "http://") === 0 )
		$parsed = substr($parsed, 7);
	if (strpos($parsed, "https://") === 0 )
		$parsed = substr($parsed, 8);
	if( strpos($parsed, "www.") === 0 )
		$parsed = substr($parsed, 4);
	$parsed = trim($parsed);
	return $parsed;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" value="IE=9">
<title><?php echo(COMPANY_TITLE) ?> Presskit - <?php echo(GAME_TITLE) ?></title>
<link href="style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="validation.js"></script>
<script>
	$(window).load( function() {
		checkVis("factsheet");
		checkVis("description");
		checkVis("history");
		checkVis("features");
		checkVis("trailers");
		checkVis("screenshots");
		checkVis("logo");
		checkVis("awards");
		checkVis("quotes");
		<?php if( $press_request == TRUE ) echo('checkVis("preview");'); ?>
		checkVis("links");
		checkVis("about");
		checkVis("credits");
		checkVis("contact");
	} );

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
		<?php if( $press_request == TRUE ) echo('checkVis("preview");'); ?>
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

<?php
	if( defined("ANALYTICS") )
	{
		if( strlen(ANALYTICS) > 10 )
		{
			?>
			<script type="text/javascript">
            
              var _gaq = _gaq || [];
              _gaq.push(['_setAccount', '<?php echo(ANALYTICS) ?>']);
			  _gaq.push(['_setCustomVar', 1, 'Game', '<?php echo( $game ) ?>']);
              _gaq.push(['_trackPageview']);

            
              (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
              })();
            
            </script>            	
            <?php
		}
	}
	?>

<!-- Page start -->
<div id="container">

    <!-- Navigation start -->
    <div id="navigation">
        <p><h1 id="game-title"><?php echo(GAME_TITLE) ?></h1>
        <strong><a href="index.php" target="_self">press kit</a></strong></p>
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
            <?php if( $press_request == TRUE) echo('<li><a href="#preview" id="m-preview" target="_self">Request Press Copy</a></li>'); ?>
            <li><a href="#links" id="m-links" target="_self">Additional Links</a></li>
            <li><a href="#about" id="m-about" target="_self">About <?php echo(COMPANY_TITLE); ?></a></li>
            <li><a href="#credits" id="m-credits" target="_self">Credits</a></li>
            <li><a href="#contact" id="m-contact" target="_self">Contact</a></li>
        </ul>
    </div>
    
    <div id="content">    	
        <!-- Header -->
        <?php 
            if( file_exists($game."/images/header.png") ) echo('<img src="'.$game.'/images/header.png" id="header" width="960" />');
        ?>
    
        <!-- Factsheet start -->
        <div id="factsheet">
        <h2>Factsheet</h2>
        
        <!-- Developer information -->
        <p><strong>Developer:</strong><br/>
        <a href="index.php"><?php echo(COMPANY_TITLE); ?></a><br/>
        Based in <?php echo(COMPANY_BASED); ?><br/></p>
        
        <!-- Release date -->
        <p><strong>Release date:</strong><br/>
        <?php echo(GAME_DATE) ?><br/></p>
        
        <!-- Platforms -->
        <p><strong>Platforms:</strong><br/>
        <?php 
            for( $i = 0; $i < count($platforms); $i++ )
            {
				$name = $link = "";
                foreach( $platforms[$i]['platform']->children() as $child )
                {
                    if( $child->getName() == "name" ) $name = $child;
                    else if( $child->getName() == "link" ) $link = $child;
                }
                echo( '<a href="http://'.parseLink($link).'/">'.$name.'</a><br/>' );
            }
        ?>
        </p>
        
        <!-- Website -->
        <p><strong>Website:</strong><br/>
        <a href="http://<?php echo parseLink(GAME_WEBSITE) ?>"><?php echo parseLink(GAME_WEBSITE) ?></a><br/></p>
        
        <!-- Pricing -->
        <p><strong>Regular Price:</strong><br/>
        <?php
			if( count($prices) == 0 )
			{
				echo('-');	
			}
			else
			{
				echo('<table>');
				for( $i = 0; $i < count($prices); $i++ )
				{
					$currency = $value = "";

					foreach( $prices[$i]['price']->children() as $child )
					{
						if( $child->getName() == "currency" ) $currency = $child;
						else if( $child->getName() == "value" ) $value = $child;
					}
					echo( '<tr><td>'.$currency.'</td><td>'.$value.'</td></tr>' );
				}
				echo('</table>');
			}
        ?>
        </table>
        </p>
        </div>
        
        <div id="right-of-factsheet">
            <!-- Description start -->
            <div id="description">
            <h2>Description</h2>
            <?php echo(GAME_DESCRIPTION) ?>
            </div>
            
            <!-- History start -->
            <div id="history">
            <h2>History</h2>
            <?php 
				if( defined("GAME_HISTORY") ) echo(GAME_HISTORY);
                for( $i = 0; $i < count($histories); $i++ )
                {
					$header = $text ="";

                    foreach( $histories[$i]['history']->children() as $child )
                    {
                        if( $child->getName() == "header" ) $header = $child;
                        else if( $child->getName() == "text" ) $text = $child;
                    }
                    echo( '<strong>'.$header.'</strong><p>'.$text.'</p>' );
                }			
			?>
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
        </div>

        <!-- Clear -->
        <div class="clear" />
                
        <!-- Trailers start -->
        <div id="trailers">
		<h2>Videos</h2>
        <?php
			if( count($trailers) == 0 )
			{
				echo('<p>There are currently no trailers available for '.GAME_TITLE.'. Check back later for more or <a href="#contact" target="_self">contact us</a> for specific requests!</p>');									
			}
			else
			{
				for( $i = 0; $i < count($trailers); $i++ )
				{
					$name = $youtube = $vimeo = $mov = $mp4 = "";
					$ytfirst = -1;
					
					foreach( $trailers[$i]['trailer']->children() as $child )
					{
						if( $child->getName() == "name" ) $name = $child;
						else if( $child->getName() == "youtube" ) { $youtube = $child; if( $ytfirst == -1 ) { $ytfirst = 1; } }
						else if( $child->getName() == "vimeo" ) { $vimeo = $child; if( $ytfirst == -1 ) { $ytfirst = 0; } }
						else if( $child->getName() == "mov" ) $mov = $child;
						else if( $child->getName() == "mp4" ) $mp4 = $child;
					}
					
					if( strlen($youtube) + strlen($vimeo) > 0 )				
					{
						echo('<p><strong>'.$name.'</strong> ');
						$result = "";
						if( strlen( $youtube ) > 0 ) $result .= '<a href="http://www.youtube.com/watch?v='.$youtube.'">YouTube</a>, ';
						if( strlen( $vimeo ) > 0 ) $result .= '<a href="http://www.vimeo.com/'.$vimeo.'">Vimeo</a>, ';
						if( strlen( $mov ) > 0 ) $result .= '<a href="'.$game.'/trailers/'.$mov.'">.mov</a>, ';
						if( strlen( $mp4 ) > 0 ) $result .= '<a href="'.$game.'/trailers/'.$mp4.'">.mp4</a>, ';
						echo( substr($result, 0, -2) );
	
						if( $ytfirst == 1 ) 
						{
							echo('<iframe width="720" height="396" src="http://www.youtube.com/embed/'.$youtube.'" frameborder="0" allowfullscreen></iframe>');
						}
						elseif ( $ytfirst == 0 )
						{
							echo('<iframe src="http://player.vimeo.com/video/'.$vimeo.'" width="720" height="540" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');
						}
					}
					else
					{
						echo('<p>There are currently no trailers available for '.GAME_TITLE.'. Check back later for more or <a href="#contact" target="_self">contact us</a> for specific requests!</p>');					
					}
					echo('</p>');
				}
			}
		?>
        </div>
        
			<!-- Clear -->
        <div class="clear" />

        <!-- Screenshots start -->
        <div id="screenshots">
        <h2>Screenshots</h2>
        <?php
		
			if( file_exists($game."/images/images.zip") )
			{
				$filesize = filesize($game."/images/images.zip");
				if( $filesize > 1024 && $filesize < 1048576 ) $filesize = (int)( $filesize / 1024 ).'KB';
				if( $filesize > 1048576 ) $filesize = (int)(( $filesize / 1024 ) / 1024 ).'MB';
				
				echo('<a href="'.$game.'/images/images.zip"><div id="media-download">download all screenshots &amp; photos as .zip ('. $filesize .')</div></a>');	
			}
		
			if ($handle = opendir($game.'/images')) {
				
				$found = 0;
				/* This is the correct way to loop over the directory. */
				while (false !== ($entry = readdir($handle))) {
					if( substr($entry,-4) == ".png" )
						if( substr($entry,0,4) != "logo" && substr($entry,0,4) != "icon" && substr($entry,0,6) != "header" )
						{	
							echo('<a href="'.$game.'/images/'.$entry.'"><div class="preview-wrapper"><img class="preview" src="'.$game.'/images/'.$entry.'" alt="'.$entry.'" /></div></a>');
							$found++;
						}
				}				
				
				if( $found == 0 ) echo('<p>There are currently no screenshots available for '.GAME_TITLE.'. Check back later for more or <a href="#contact" target="_self">contact us</a> for specific requests!</p>');
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
			if( file_exists($game."/images/logo.zip") )
			{
				$filesize = filesize($game."/images/logo.zip");
				if( $filesize > 1024 && $filesize < 1048576 ) $filesize = (int)( $filesize / 1024 ).'KB';
				if( $filesize > 1048576 ) $filesize = (int)(( $filesize / 1024 ) / 1024 ).'MB';
				
				echo('<a href="'.$game.'/images/logo.zip"><div id="media-download">download logo files as .zip ('. $filesize .')</div></a>');	
			}

        	if( file_exists($game.'/images/logo.png') ) echo( '<a href="'.$game.'/images/logo.png"><img src="'.$game.'/images/logo.png" alt="logo" /></a>' );
        	if( file_exists($game.'/images/icon.png') ) echo( '<a href="'.$game.'/images/icon.png"><img src="'.$game.'/images/icon.png" alt="logo" /></a>' );
			if( !file_exists($game.'/images/logo.png') && !file_exists($game.'/images/icon.png'))
			echo('<p>There are currently no logos or icons available for '.GAME_TITLE.'. Check back later for more or <a href="#contact" target="_self">contact us</a> for specific requests!</p>');
		?>
        </div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Award start -->
        <div id="awards">
        <h2>Awards & Recognition</h2>
        <?php 
			if( count($promoterawards) >= 0 )
			{
				echo('<ul>');				
				for( $i = 0; $i < count($promoterawards); $i++ )
				{
					$description = $info = "";
					foreach( $promoterawards[$i]['award']->children() as $child )
					{
						if( $child->getName() == "title" ) $description = $child;
						else if( $child->getName() == "location" ) $info = $child;
						else if( $child->getName() == "url" ) $url = $child;
						else if( $child->getName() == "year" ) $year = $child;
					}
					echo( '<li>"'.$description.'" <cite>'.$info.'</cite></li>' );
				}			
				echo('</ul>');				
			}

			if( count($awards) + count($promoterawards) == 0 )
			{
				echo('<p>'.GAME_TITLE.' has not received any awards or recognitions yet. Please check back later to see if things change.</p>');
			}
			else
			{
				echo('<ul>');				
				for( $i = 0; $i < count($awards); $i++ )
				{
					$description = $info = "";
					foreach( $awards[$i]['award']->children() as $child )
					{
						if( $child->getName() == "description" ) $description = $child;
						else if( $child->getName() == "info" ) $info = $child;
					}
					echo( '<li>"'.$description.'" <cite>'.$info.'</cite></li>' );
				}			
				echo('</ul>');				
			}
		?>
        </ul>
        </div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Quote start -->
        <div id="quotes">
        <h2>Selected Articles</h2>
        <?php 
			if( count($promoterquotes) >= 0 )
			{
				echo('<ul>');
				for( $i = 0; $i < count($promoterquotes); $i++ )
				{
					$name = $description = $website = $link = "";
					foreach( $promoterquotes[$i]['review']->children() as $child )
					{
						if( $child->getName() == "quote" ) $description = $child;
						else if( $child->getName() == "reviewer-name" ) $name = $child;
						else if( $child->getName() == "publication-name" ) $website = $child;
						else if( $child->getName() == "url" ) $link = $child;
					}
					echo( '<li>"'.$description.'" <br/>
					<cite>- '.$name.', <a href="http://'.parseLink($link).'">'.$website.'</a></cite></li>' );
				}
				echo('</ul>');				
			}
		
			if( count($quotes) + count($promoterquotes) == 0 )
			{
				echo('<p>'.GAME_TITLE.' hasn\'t been the subject of any interesting article or (p)review yet. You could be the first!</p>');
			}
			else
			{
				echo('<ul>');
				for( $i = 0; $i < count($quotes); $i++ )
				{
					$name = $description = $website = $link = "";
					foreach( $quotes[$i]['quote']->children() as $child )
					{
						if( $child->getName() == "description" ) $description = $child;
						else if( $child->getName() == "name" ) $name = $child;
						else if( $child->getName() == "website" ) $website = $child;
						else if( $child->getName() == "link" ) $link = $child;
					}
					echo( '<li>"'.$description.'" <br/>
					<cite>- '.$name.', <a href="http://'.parseLink($link).'/">'.$website.'</a></cite></li>' );
				}
				echo('</ul>');
			}
		?>
        </div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Request Preview Copy -->
        <?php
			if( $press_request == TRUE )
			{
				?>
                <div id="preview">
                <h2>Request Press Copy</h2>
                <p>Please fill in your e-mail address below and we'll get back to you as soon as a press copy is available for you.<br/>
                <div id="mailform"><input type="text" value="me@website.com" id="from" />, writing for <input type="text" value="company name" id="outlet" /> would like to <input type="button" id="submit-button" value="request a press copy" /><br/>&nbsp;<br/>Alternatively, you can always request a press copy by <a href="#contact" target="_self">sending us a quick email</a>.</div>
                <div id="mailsuccess" style="display:none;">Thanks for the request. We'll be in touch as soon as possible. In the meanwhile, feel free to <a href="#contact" target="_self">follow up with any questions or requests you might have!</a></div>
                </p></div>
                
                <!-- Clear -->
                <div class="clear" />
                <?php
			}
		?>

        <!-- Links -->
        <div id="links">
        <h2>Additional Links</h2>
        <?php 
			for( $i = 0; $i < count($additionals); $i++ )
			{
				$title = $description = $link = "";
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
        <h2>About <?php echo(COMPANY_TITLE); ?></h2>
        <p><strong>Boilerplate</strong><br/>
		<?php echo(COMPANY_DESCRIPTION);?></p>
		
        <p><strong>More information</strong><br/>
        More information on <?php echo(COMPANY_TITLE); ?>, our logo & relevant media are available <a href="index.php">here</a>.</p>
        </div>
        
		<!-- Clear -->
        <div class="clear" />
        
        <!-- Credits -->
        <div id="credits">
        <h2><?php echo( GAME_TITLE ) ?> Credits</h2>
        <?php 
			for( $i = 0; $i < count($credits); $i++ )
			{
				$previous = $person = $website = $role = "";
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
        <!-- Contact -->
        <div id="contact">
        <h2>Contact</h2>
        <?php 
			for( $i = 0; $i < count($contacts); $i++ )
			{
				$name = $link = $mail = "";
				foreach( $contacts[$i]['contact']->children() as $child )
				{
					if( $child->getName() == "name" ) $name = $child;
					else if( $child->getName() == "link" ) $link = $child;
					else if( $child->getName() == "mail" ) $mail = $child;
				}
				
				if( strlen($link) == 0 && strlen($mail) > 0 )
					echo( '<p><strong>'.$name.'</strong><br/><a href="mailto:'.$mail.'">'.$mail.'</a>');
				if( strlen($link) > 0 && strlen($mail) == 0 )
					echo( '<p><strong>'.$name.'</strong><br/><a href="http://www.'.parseLink($link).'">'.parseLink($link).'</a>');
			}
		?>
        </div>

		<!-- Clear -->
        <div class="clear" />

		<p class="credits"><a href="http://dopresskit.com/">presskit()</a> by Rami Ismail (<a href="http://www.vlambeer.com/">Vlambeer</a>) - also thanks to <a href="?p=credits">these fine folks</a></p>

    </div>
</div>

</body>
</html>
