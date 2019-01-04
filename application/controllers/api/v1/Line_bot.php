<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;

class Line_bot extends CI_Controller{
    private $app;
    public function __construct() {
        if($this->environment_is("development")){
            $this->dotenv_initiation();
        }
        $this->slim_config();
        $this->slim_api();
    }

    public function webhook(){}
    
    // private function section
    private function slim_config(){
        $configs =  [
            'settings' => ['displayErrorDetails' => true],
        ];
        $this->app = new Slim\App($configs);
    }

    private function slim_api(){
        $this->app->get('/api_test', function () {
            return "hello, it works!";
        });
        $this->app->get('/api/line/webhook', function ($request, $response) {
            return $response->withStatus(200);
        });
        $this->app->post('/api/line/webhook', function ($request, $response)
        {
            // get request body and line signature header
            $body 	   = file_get_contents('php://input');
            $signature = $_SERVER['HTTP_X_LINE_SIGNATURE'];
            // log body and signature
            file_put_contents('php://stderr', 'Body: '.$body);
            // is LINE_SIGNATURE exists in request header?
            if (empty($signature)){
                return $response->withStatus(400, 'Signature not set');
            }
            // is this request comes from LINE?
            if($_ENV['PASS_SIGNATURE'] == false && ! SignatureValidator::validateSignature($body, $_ENV['CHANNEL_SECRET'], $signature)){
                return $response->withStatus(400, 'Invalid signature');
            }
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
            
        });
        $this->app->run();
    }
    
    private function environment_is($environment){
        return isset($_ENV['CI_ENV']) && $environment === $_ENV['CI_ENV'] ? TRUE : FALSE;
    }

    private function dotenv_initiation(){
        $dotenv = new Dotenv\Dotenv(__DIR__);
        $dotenv->load();
    }
}
