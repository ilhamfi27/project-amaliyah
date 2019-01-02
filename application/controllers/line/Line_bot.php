<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \LINE\LINEBot\SignatureValidator as SignatureValidator;

class Line_bot extends CI_Controller{
    public function index(){
        echo "hai";
    }

    public function webhook(){
        // init bot
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['CHANNEL_ACCESS_TOKEN']);
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['CHANNEL_SECRET']]);
        $data = json_decode($body, true);
        foreach ($data['events'] as $event)
        {
            $userMessage = $event['message']['text'];
            if(strtolower($userMessage) == 'halo')
            {
                $message = "Halo juga";
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                $result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);
                return $result->getHTTPStatus() . ' ' . $result->getRawBody();
            }
        }
    }
}
