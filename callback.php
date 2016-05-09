<?php 
// use LINE\LINEBot;
// use LINE\LINEBot\HTTPClient\GuzzleHttp\Client;
// use LINE\LINEBot\HTTPClient\GuzzleHTTPClient;

// require 'vendor/autoload.php';

// $filename = "test.txt";  
// $file = fopen($filename, "w");                      //以寫模式打開文件   

// $config = [
//     'channelId' => '1466438888',
//     'channelSecret' => 'ce965595796b4df5007d93b8b249cd2a',
//     'channelMid' => 'ub371d7f1ad9c29627c24a2377fc3ba09',
// ];
// $bot = new LINEBot($config, new GuzzleHTTPClient($config));

//     $entityBody = file_get_contents('php://input');
//     if (!empty($entityBody)) {
//         $receives = $bot->createReceivesFromJSON($entityBody);
//         foreach ($receives as $receive) {
//             if ($receive->isMessage()) {

//                 /** @var Message $receive */

//                 // $this->logger->info(sprintf(
//                 //     'contentId=%s, fromMid=%s, createdTime=%s',
//                 //     $receive->getContentId(),
//                 //     $receive->getFromMid(),
//                 //     $receive->getCreatedTime()
//                 // ));

//                 if ($receive->isText()) {
// fwrite($file, "1"."\n");                 //換行\n ；window下要加 \r\n
//                     /** @var Text $receive */
//                     if ($receive->getText() === 'me') {
// fwrite($file, "2"."\n");                 //換行\n ；window下要加 \r\n
//                         $ret = $bot->getUserProfile($receive->getFromMid());
//                         $contact = $ret['contacts'][0];
//                         $multipleMsgs = (new MultipleMessages())
//                             ->addText(sprintf(
//                                 'Hello! %s san! Your status message is %s',
//                                 $contact['displayName'],
//                                 $contact['statusMessage']
//                             ))
//                             ->addImage($contact['pictureUrl'], $contact['pictureUrl'])
//                             ->addSticker(mt_rand(0, 10), 1, 100);
//                         $bot->sendMultipleMessages($receive->getFromMid(), $multipleMsgs);
//                     } else {
// fwrite($file, "text".$receive->getText()."\n");                 //換行\n ；window下要加 \r\n
// fwrite($file, "MID".$receive->getFromMid()."\n");                 //換行\n ；window下要加 \r\n
//                         $back=$bot->sendText($receive->getFromMid(), $receive->getText() );
// fwrite($file, print_r($back)."\n");                 //換行\n ；window下要加 \r\n
// fwrite($file, '4'."\n");                 //換行\n ；window下要加 \r\n
//                     }
//                 } elseif ($receive->isImage() || $receive->isVideo()) {
//                     $content = $bot->getMessageContent($receive->getContentId());
//                     $meta = stream_get_meta_data($content->getFileHandle());
//                     $contentSize = filesize($meta['uri']);
//                     $type = $receive->isImage() ? 'image' : 'video';

//                     $previewContent = $bot->getMessageContentPreview($receive->getContentId());
//                     $previewMeta = stream_get_meta_data($previewContent->getFileHandle());
//                     $previewContentSize = filesize($previewMeta['uri']);
// fwrite($file, "5"."\n");                 //換行\n ；window下要加 \r\n
//                     $bot->sendText(
//                         $receive->getFromMid(),
//                         "Thank you for sending a $type.\nOriginal file size: " .
//                         "$contentSize\nPreview file size: $previewContentSize"
//                     );
//                 } elseif ($receive->isAudio()) {
//                     $bot->sendText($receive->getFromMid(), "Thank you for sending a audio.");
//                 } elseif ($receive->isLocation()) {
//                     /** @var Location $receive */
//                     $bot->sendLocation(
//                         $receive->getFromMid(),
//                         sprintf("%s\n%s", $receive->getText(), $receive->getAddress()),
//                         $receive->getLatitude(),
//                         $receive->getLongitude()
//                     );
//                 } elseif ($receive->isSticker()) {
// fwrite($file, "6"."\n");                 //換行\n ；window下要加 \r\n
//                     /** @var Sticker $receive */
//                     // $bot->sendSticker(
//                     //     $receive->getFromMid(),
//                     //     $receive->getStkId(),
//                     //     $receive->getStkPkgId(),
//                     //     $receive->getStkVer()
//                     // );
//                 } elseif ($receive->isContact()) {
// fwrite($file, "7"."\n");                 //換行\n ；window下要加 \r\n
//                     /** @var Contact $receive */
//                     $bot->sendText(
//                         $receive->getFromMid(),
//                         sprintf("Thank you for sending %s information.", $receive->getDisplayName())
//                     );
//                 } else {
//                     throw new \Exception("Received invalid message type");
//                 }
//             } elseif ($receive->isOperation()) {
//                 /** @var Operation $receive */

//                 // $this->logger->info(sprintf(
//                 //     'revision=%s, fromMid=%s',
//                 //     $receive->getRevision(),
//                 //     $receive->getFromMid()
//                 // ));

//                 if ($receive->isAddContact()) {
//                     $bot->sendText($receive->getFromMid(), "Thank you for adding me to your contact list!");
//                 } elseif ($receive->isBlockContact()) {
//                     // $this->logger->info("Blocked");
//                 } else {
//                     throw new \Exception("Received invalid operation type");
//                 }
//             } else {
//                 throw new \Exception("Received invalid receive type");
//             }
//         }
//     } else {
//         echo "listening...";
//     }

// fclose($file);                                      //關閉文件   


// exit;



/* 輸入申請的Line Developers 資料  */
$channel_id = "1466438888";
$channel_secret = "ce965595796b4df5007d93b8b249cd2a";
$mid = "ub371d7f1ad9c29627c24a2377fc3ba09";


$receive = json_decode(file_get_contents("php://input"));
$text = $receive->result{0}->content->text;
$from = $receive->result[0]->content->from;
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

    // /* 將收到的資料整理至變數 */
    // $receive = json_decode(file_get_contents("php://input"));
    // $text = $receive->result{0}->content->text;
    // $from = $receive->result[0]->content->from;
    // $content_type = $receive->result[0]->content->contentType;
     
    // /* 準備Post回Line伺服器的資料 */
    // $header = ["Content-Type: application/json; charser=UTF-8", "X-Line-ChannelID:" . $channel_id, "X-Line-ChannelSecret:" . $channel_secret, "X-Line-Trusted-User-With-ACL:" . $mid];
    // $message = getBoubouMessage($content_type, $text);
    // sendMessage($header, $from, $message);
     
    // /* 發送訊息 */
    // function sendMessage($header, $to, $message) {
     
    //     $url = "https://trialbot-api.line.me/v1/events";
    //     $data = ["to" => [$to], "toChannel" => 1383378250, "eventType" => "138311608800106203", "content" => ["contentType" => 1, "toType" => 1, "text" => $message]];
    //     $context = stream_context_create(array(
    //     "http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
    //     ));
    //     file_get_contents($url, false, $context);
    // }
     
    // function getBoubouMessage( $type, $value){  
    //     if($type == 1){
    //         return "寶寶" . $value ."，只是寶寶不說";
    //     }else{
    //         return "寶寶看不懂，只是寶寶不說";
    //     }
    // }

// /* 將收到的資料整理至變數 */
// $receive = json_decode(file_get_contents("php://input"));
// $text = $receive->result{0}->content->text; //接收到的資料
// $from = $receive->result[0]->content->from; //來自 
// $content_type = $receive->result[0]->content->contentType; 
 
// /* 準備Post回Line伺服器的資料 */

// $header = ["Host: trialbot-api.line.me","Content-Type: application/json; charser=UTF-8", " X-Line-ChannelID: " . $channel_id, "X-Line-ChannelSecret: " . $channel_secret, " X-Line-Trusted-User-With-ACL: " . $mid];
// $message = getBoubouMessage($text);
// sendMessage($header, $from, $text);

 
// /* 發送訊息 */
// function sendMessage($header, $to, $message) {
 
//     $url = "https://trialbot-api.line.me/v1/events"; //都是固定值
//     $data = ["to" => [$to], "toChannel" => 1383378250, "eventType" => "138311608800106203", "content" => ["contentType" => 1, "toType" => 1, "text" => $message]];
//     // stream_context_create
//     // http_build_query
//     $context = stream_context_create(array("http" => array("method" => "POST", "header" => implode('\r\n', $header), "content" => json_encode($data))));


// // $ch = curl_init();
// // curl_setopt($ch, CURLOPT_URL, $url);
// // curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
// // curl_setopt($ch, CURLOPT_POSTFIELDS, $context);
// // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// // $html = curl_exec($ch); 
// // curl_close($ch);

// $filename = "test.txt";  
// $file = fopen($filename, "w");                      //以寫模式打開文件   
// fwrite($file, (string)(json_encode($data))."\n");                 //換行\n ；window下要加 \r\n
// fclose($file);                                      //關閉文件   


//     file_get_contents($url, false, $context);
// }
 
// // function getBoubouMessage($value){      
// //     return "寶寶" . $value ."，只是寶寶不說";
// // }





 ?>

