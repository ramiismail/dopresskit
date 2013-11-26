<?php

$xml = simplexml_load_file("data.xml");

foreach( $xml->children() as $child )
{
	switch( $child->getName() )
	{
		case("press-contact"):
			$to = $child;
			break;
	}
}

$from = $_REQUEST['from'];
$message = $_REQUEST['content'];
$subject = $_REQUEST['subject'];
$header = "From: <".$from.">" ."\r\n";

$send = @mail($to, $subject, $message, $header);

if(!$send){
	die();
}

?>