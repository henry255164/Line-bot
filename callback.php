<?php 
/* 輸入申請的Line Developers 資料  */
$channel_id     = "";
$channel_secret = "";
$mid            = "";


$receive = json_decode(file_get_contents("php://input"));
$text         = $receive->result{0}->content->text;
$from         = $receive->result[0]->content->from;
$content_type = $receive->result[0]->content->contentType;

$header = ["Content-Type: application/json; charser=UTF-8", "X-Line-ChannelID:" . $channel_id, "X-Line-ChannelSecret:" . $channel_secret, "X-Line-Trusted-User-With-ACL:" . $mid];
$message = getContentType($content_type);
sendMessage($header, $from, $message);

function sendMessage($header, $to, $message) {
$url = "https://trialbot-api.line.me/v1/events";
$data = ["to" => [$to], "toChannel" => 1383378250, "eventType" => "138311608800106203", "content" => ["contentType" => 1, "toType" => 1, "text" => $message]];
$context = stream_context_create(array(
"http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
));
file_get_contents($url, false, $context);
}

function getContentType($value) {

$content_type = "";
switch($value) {

case 1 :
$content_type = "Text message";
break;
case 2 :
$content_type = "Image message";
break;
case 3 :
$content_type = "Video message";
break;
case 4 :
$content_type = "Video message";
break;
case 7 :
$content_type = "Location message";
break;
case 8 :
$content_type = "Sticker message";
break;
case 10 :
$content_type = "Contact message";
break;
default:
$content_type = "unknown";
break;
}

return $content_type;
}
exit;


 ?>

