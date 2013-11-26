<?php
if( file_exists('install.php') )
{
	include('install.php');
	die();
}

if( !file_exists('data.xml') )
{
	if( file_exists('_data.xml') )
	{
		echo('<html>');
		echo('<head><title>Instructions</title><link href="style.css" rel="stylesheet" type="text/css" />');
		echo('<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>');
		echo('<body><div id="container"></div>');
		echo('<script>$("#container").load("create.php?s=installation"); setInterval( function() { $("#container").load("create.php?s=installation") }, 5000 )</script>');
		echo('</body></html>');
		die();
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
		case("founding-date"):
			define("COMPANY_DATE", $child);
			break;
		case("website"):
			define("COMPANY_WEBSITE", $child);
			break;
		case("press-contact"):
			define("COMPANY_CONTACT", $child);
			break;
		case("based-in"):
			define("COMPANY_BASED", $child);
			break;
		case("analytics"):
			define("ANALYTICS", $child);
			break;
		case("socials"):
			$socials = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$socials[$i][$subchild->getName()] = $subchild;
				$i++;
			}
			break;
		case("address"):
			$address = array();
			$i = 0;
			foreach( $child->children() as $subchild )
			{
				$address[$i] = $subchild;
				$i++;
			}
			break;	
		case("phone"):
			define("COMPANY_PHONE", $child);
			break;
		case("description"):
			define("COMPANY_DESCRIPTION", $child);
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

function parseHubLink($uri)
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
<title><?php echo(COMPANY_TITLE); ?> Presskit</title>
<link href="style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="validation.js"></script>
<script>
	$(window).load( function() {
		checkVis("factsheet");
		checkVis("description");
		checkVis("history");
		checkVis("projects");
		checkVis("trailers");
		checkVis("images");
		checkVis("logo");
		checkVis("awards");
		checkVis("quotes");
		<?php if( count($additionals) > 0 ) echo('checkVis("links");'); ?>
		checkVis("credits");
		checkVis("contact");
	} );

	$(window).scroll( function() {
		checkVis("factsheet");
		checkVis("description");
		checkVis("history");
		checkVis("projects");
		checkVis("trailers");
		checkVis("images");
		checkVis("logo");
		checkVis("awards");
		checkVis("quotes");
		<?php if( count($additionals) > 0 ) echo('checkVis("links");'); ?>
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
        <p><h1 id="game-title"><?php echo COMPANY_TITLE ?></h1>
        <strong><a href="http://<?php echo parseHubLink(COMPANY_WEBSITE) ?>" target="_self"><?php echo trim( parseHubLink(COMPANY_WEBSITE), "/") ?></a></strong></p>
        <br/>
        <ul>
            <li><a href="#factsheet" id="m-factsheet" target="_self">Factsheet</a></li>
            <li><a href="#description" id="m-description" target="_self">Description</a></li>
            <li><a href="#history" id="m-history" target="_self">History</a></li>
            <li><a href="#projects" id="m-projects" target="_self">Projects</a></li>
            <li><a href="#trailers" id="m-trailers" target="_self">Videos</a></li>
            <li><a href="#images" id="m-images" target="_self">Images</a></li>
            <li><a href="#logo" id="m-logo" target="_self">Logo & Icon</a></li>
            <li><a href="#awards" id="m-awards" target="_self">Awards & Recognition</a></li>
            <li><a href="#quotes" id="m-quotes" target="_self">Selected Articles</a></li>
            <?php if( count($additionals) > 0 ) echo('<li><a href="#links" id="m-links" target="_self">Additional Links</a></li>'); ?>
            <li><a href="#credits" id="m-credits" target="_self">Team</a></li>
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
        <a href=""><?php echo COMPANY_TITLE ?></a><br/>
        Based in <?php echo COMPANY_BASED ?><br/></p>
        
        <!-- Release date -->
        <p><strong>Founding date:</strong><br/>
        <?php echo COMPANY_DATE ?><br/></p>
                
        <!-- Website -->
        <p><strong>Website:</strong><br/>
        <?php echo('<a href="http://'.parseHubLink(COMPANY_WEBSITE).'">'.parseHubLink(COMPANY_WEBSITE).'</a><br/></p>'); ?>

        <!-- Website -->
        <p><strong>Press / Business Contact:</strong><br/>
        <?php echo('<a href="mailto:'.COMPANY_CONTACT.'">'.COMPANY_CONTACT.'</a><br/></p>') ?>
        
        <!-- Pricing -->
        <p><strong>Social:</strong><br/>
        <?php 
			for( $i = 0; $i < count($socials); $i++ )
			{
				$name = $link = "";

				foreach( $socials[$i]['social']->children() as $child )
				{
					if( $child->getName() == "name" ) $name = $child;
					else if( $child->getName() == "link" ) $link = $child;
				}
				echo( '<a href="http://'.parseHubLink($link).'">'.$name.'</a><br/>' );
			}
		?>
        </p>

        <!-- Platforms -->
        <p><strong>Releases:</strong><br/>
        <?php
			if ($handle = opendir('.')) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != ".." && substr($entry,0,1) != "_" && strpos($entry, ".") === FALSE && substr($entry,0,6) != "images" && substr($entry,0,8) != "trailers" ) {
						echo('<a href="sheet.php?p='.$entry.'">'.ucwords(str_replace("_", " ", $entry)).'</a></br>');
					}
				}
			}
			closedir($handle);
		?>
        </p>

		<?php 
		if( count($address) > 0 )
		{
			echo('<p><strong>Address:</strong><br/>');
			for( $i = 0; $i < count($address); $i++ )
			{
				echo($address[$i].'<br/>');
			}
			echo('</p>');
        }
        ?>  

        <p><strong>Phone:</strong><br/>
        <?php echo( COMPANY_PHONE ); ?>
        </p>

        </div>
        
        <!-- Description start -->
        <div id="right-of-factsheet">
            <div id="description">
            <h2>Description</h2>
            <?php echo( COMPANY_DESCRIPTION ); ?>
            </div>
            
            <!-- History start -->
            <div id="history">
            <h2>History</h2>        
			<?php 
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
            <div id="projects">
            <h2>Projects</h2>
            <ul>
            <?php
                if ($handle = opendir('.')) {
                    while (false !== ($entry = readdir($handle))) {
                        if ($entry != "." && $entry != ".." && substr($entry,0,1) != "_" && strpos($entry, ".") === FALSE && substr($entry,-4) != ".log" && substr($entry,0,6) != "images" && substr($entry,0,8) != "trailers" ) {
                            echo('<li><a href="sheet.php?p='.$entry.'">'.ucwords(str_replace("_", " ", $entry)).'</a></li>');
                        }
                    }
                }
                closedir($handle);
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
					if( strlen( $mov ) > 0 ) $result .= '<a href="trailers/'.$mov.'">.mov</a>, ';
					if( strlen( $mp4 ) > 0 ) $result .= '<a href="trailers/'.$mp4.'">.mp4</a>, ';
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
					echo('<p>There are currently no trailers available for '.COMPANY_TITLE.'. Check back later for more or <a href="#contact" target="_self">contact us</a> for specific requests!</p>');					
				}
				echo('</p>');
			}
		?>
        </div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Screenshots start -->
        <div id="images">
        <h2>Images</h2>
        <?php
		
			if( file_exists("images/images.zip") )
			{
				$filesize = filesize("images/images.zip");
				if( $filesize > 1024 && $filesize < 1048576 ) $filesize = (int)( $filesize / 1024 ).'KB';
				if( $filesize > 1048576 ) $filesize = (int)(( $filesize / 1024 ) / 1024 ).'MB';
				
				echo('<a href="images/images.zip"><div id="media-download">download all screenshots &amp; photos as .zip ('. $filesize .')</div></a>');	
			}
		
			if ($handle = opendir('images')) {
				
				$found = 0;
				/* This is the correct way to loop over the directory. */
				while (false !== ($entry = readdir($handle))) {
					if( substr($entry,-4) == ".png" )
						if( substr($entry,0,4) != "logo" && substr($entry,0,4) != "icon" && substr($entry,0,6) != "header" )
						{	
							echo('<a href="images/'.$entry.'"><div class="preview-wrapper"><img class="preview" src="images/'.$entry.'" alt="'.$entry.'" /></div></a>');
							$found++;
						}
				}				
			}
			
			closedir($handle);
			
				echo('<p style="clear:both">There are far more images available for '.COMPANY_TITLE.', but these are the ones we felt would be most useful to you. If you have specific requests, please do <a href="#contact" target="_self">contact us</a>!</p>');
			
		?>        
        </div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Logo start -->
        <div id="logo">
        <h2>Logo & Icon</h2>
        <?php
			if( file_exists("images/logo.zip") )
			{
				$filesize = filesize("images/logo.zip");
				if( $filesize > 1024 && $filesize < 1048576 ) $filesize = (int)( $filesize / 1024 ).'KB';
				if( $filesize > 1048576 ) $filesize = (int)(( $filesize / 1024 ) / 1024 ).'MB';
				
				echo('<a href="images/logo.zip"><div id="media-download">download logo files as .zip ('. $filesize .')</div></a>');	
			}

        	if( file_exists('images/logo.png') ) echo( '<a href="images/logo.png"><img src="images/logo.png" alt="logo" /></a>' );
        	if( file_exists('images/icon.png') ) echo( '<a href="images/icon.png"><img src="images/icon.png" alt="logo" /></a>' );
			if( !file_exists('images/logo.png') && !file_exists('images/icon.png'))
			echo('<p>There are currently no logos or icons available for '.COMPANY_TITLE.'. Check back later for more or <a href="#contact" target="_self">contact us</a> for specific requests!</p>');
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
				$description = $info = "";
				
				foreach( $awards[$i]['award']->children() as $child )
				{
					if( $child->getName() == "description" ) $description = $child;
					else if( $child->getName() == "info" ) $info = $child;
				}
				echo( '<li>"'.$description.'" - <cite>'.$info.'</cite></li>' );
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
				$description = $name = $website = $link = "";
				
				foreach( $quotes[$i]['quote']->children() as $child )
				{
					if( $child->getName() == "description" ) $description = $child;
					else if( $child->getName() == "name" ) $name = $child;
					else if( $child->getName() == "website" ) $website = $child;
					else if( $child->getName() == "link" ) $link = $child;
				}
				echo( '<li>"'.$description.'" <br/>
				<cite>- '.$name.', <a href="http://'.parseHubLink($link).'/">'.$website.'</a></cite></li>' );
			}
		?>
        </ul>
        </div>
        
		<!-- Clear -->
        <div class="clear" />

        <!-- Links -->
        <?php 
		if( count($additionals) > 0 )
		{
			echo('<div id="links">');
	        echo('<h2>Additional Links</h2>');
			for( $i = 0; $i < count($additionals); $i++ )
			{
				$title = $description = $link = "";
				
				foreach( $additionals[$i]['additional']->children() as $child )
				{
					if( $child->getName() == "title" ) $title = $child;
					else if( $child->getName() == "description" ) $description = $child;
					else if( $child->getName() == "link" ) $link = $child;
				}
				
				echo('<p><strong>'.$title.'</strong><br/>'.$description.' <a href="http://'.parseHubLink($link).'/" alt="'.parseHubLink($link).'">'.substr(parseHubLink($link),0,strpos(parseHubLink($link), "/")).'</a>.</p>');
			}
			echo('</div>');
			echo('<!-- Clear --><div class="clear" />');
		}
		?>        
        
        <!-- Credits -->
        <div id="credits">
        <h2>Team & Repeating<br/>Collaborators</h2>
        <?php 
			for( $i = 0; $i < count($credits); $i++ )
			{
				$previous = $website = $person = $role = "";
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
					echo('<p><strong>'.$person.'</strong><br/><a href="http://'.parseHubLink($website).'/">'.$role.'</a>');					
				}
								
				echo('</p>');
			}
		?>
        </div>
        
        <!-- Contact -->
        <div id="contact">
        <h2>Contact</h2>
        <?php 
			for( $i = 0; $i < count($contacts); $i++ )
			{
				$link = $mail = $name = "";
				foreach( $contacts[$i]['contact']->children() as $child )
				{
					if( $child->getName() == "name" ) $name = $child;
					else if( $child->getName() == "link" ) $link = $child;
					else if( $child->getName() == "mail" ) $mail = $child;
				}
				
				if( strlen($link) == 0 && strlen($mail) > 0 )
					echo( '<p><strong>'.$name.'</strong><br/><a href="mailto:'.$mail.'">'.$mail.'</a>');
				if( strlen($link) > 0 && strlen($mail) == 0 )
					echo( '<p><strong>'.$name.'</strong><br/><a href="http://'.parseHubLink($link).'">'.parseHubLink($link).'</a>');
			}
		?>
        </div>

		<!-- Clear -->
        <div class="clear" />

		<p class="credits"><a href="http://dopresskit.com/">presskit()</a> by Rami Ismail (<a href="http://www.vlambeer.com/">Vlambeer</a>) - also thanks to <a href="sheet.php?p=credits">these fine folks</a></p>

    </div>
</div>

</body>
</html>
