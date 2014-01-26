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
$outlet = htmlentities($_REQUEST['outlet']);
$game = htmlentities($_REQUEST['game']);
$gametitle = htmlentities($_REQUEST['gametitle']);

$subject = '[Request] ' . $gametitle . ' Press Copy For ' . $outlet;
$message = wordwrap($from . ' of ' . $outlet . ' has requested a Press Copy for ' . $gametitle . ' through the press kit interface.', 70, "\r\n");

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
	} else {
		$json['success'] = False;

		if ($result == 'fromerror') {
			$json['error'] = 'from';
		} else if ($result == 'emptyerror') {
			$json['error'] = 'empty';
		} else {
			$json['error'] = 'notsend';
		}
	}

	echo json_encode($json);
} else {
	header("Location: sheet.php?p=$game&mail=$result#preview");
}

?>
