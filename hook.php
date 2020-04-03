<?php

$token = "token";
$update = json_decode(file_get_contents("php://input"), TRUE);
$from_id = $update["message"]["from"]["id"];
$from_username = $update["message"]["from"]["username"];
$admins = array('id of admins here');

if (isset($update["message"]["reply_to_message"]))
{
	$rmessage = $update["message"]["reply_to_message"];
}
else
{
	$rmessage = false;
}

if ($rmessage && in_array($from_id, $admins))
{
	$rtext = $rmessage["text"];
	preg_match('/id: (\d+)/', $rtext, $matches);
	$sender_id = $matches[1];
	$message_text = $update["message"]["text"];
	file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$sender_id$&text=$message_text");

}
$message_text = $update["message"]["text"];
$text = urlencode("$message_text\nFrom: @$from_username - id: $from_id");
foreach ($admins as $value) {
	if ($value!=$from_id)
	{
		file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$value&text=$text");
	}
}
?>
