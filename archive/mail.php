<?php

// Language logic

include 'lang/TranslateTool.php';
$language = TranslateTool::loadLanguage(isset($_REQUEST['l']) ? $_REQUEST['l'] : null, 'mail.php');
$languages = TranslateTool::getLanguages();
$languageParam = ($language != TranslateTool::getDefaultLanguage() ? '&l='. $language : '');

if (file_exists('data-'. $language .'.xml'))
	$xml = simplexml_load_file('data-'. $language .'.xml');
else
	$xml = simplexml_load_file('data.xml');

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
$outlet = htmlentities($_REQUEST['outlet']);
$game = htmlentities($_REQUEST['game']);
$gametitle = htmlentities($_REQUEST['gametitle']);

$subject = '[Request] ' . $gametitle . ' Press Copy For ' . $outlet;
$message = wordwrap($from . ' of ' . $outlet . ' has requested a Press Copy for ' . $gametitle . ' through the press kit interface'. ($language != TranslateTool::getDefaultLanguage() ? ' in language '. $languages[$language] :'') .'.', 70, "\r\n");

$headers  = 'From: ' . $from . "\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion();

if (filter_var($from, FILTER_VALIDATE_EMAIL)) {
	if (empty($outlet) OR empty($game) OR empty($gametitle)) {
		$result = 'emptyerror';
	} else {
		$mail = mail($to, $subject, $message, $headers);

		if ($mail) {
			$result = 'success';
		} else {
			$result = 'error';
		}
	}
} else {
	$result = 'fromerror';
}

if (isset($_GET['ajax'])) {
	header("Content-type: application/json");
	$json = array();
	
	if ($result == 'success') {
		$json['success'] = True;
		$json['message'] = (string)tlHtml('Thanks for the request. We\'ll be in touch as soon as possible. In the meanwhile, feel free to <a href="#contact">follow up with any questions or requests you might have!</a>');
	} else {
		$json['success'] = False;

		if ($result == 'fromerror') {
			$json['error'] = 'from';
			$json['message'] = (string)tlHtml('We could not validate your email address. Please try contacting us using <a href="#contact">one of the options listed here</a>.');
		} else if ($result == 'emptyerror') {
			$json['error'] = 'empty';
			$json['message'] = (string)tlHtml('Please fill in all the fields or try contacting us using <a href="#contact">one of the options listed here</a>.');
		} else {
			$json['error'] = 'notsend';
			$json['message'] = (string)tlHtml('We failed to send the email. Please try contacting us using <a href="#contact">one of the options listed here</a>.');
		}
	}

	echo json_encode($json);
} else {
	header("Location: sheet.php?p=$game&mail=$result$languageParam#preview");
}

?>
