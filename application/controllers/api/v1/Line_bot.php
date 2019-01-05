<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

use LINE\LINEBot\SignatureValidator as SignatureValidator;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;

class Line_bot extends CI_Controller{
    private $app;
    private $bot;
    private $pass_signature;

    public function __construct() {
        if($this->environment_is("development")){
            $this->dotenv_initiation();
        }
        $this->slim_config();
        $this->bot_init();
    }
    
    public function index(){
        $this->app->get('/api/line/', function ($request, $response) {
            return $response->withStatus(200);
        });
        $this->app->run();
    }
    public function webhook(){
        $bot            = $this->bot;
        $pass_signature = $this->pass_signature;

        $this->app->get('/api/line/webhook', function ($request, $response) {
            echo "Hi, There!";
            return $response->withStatus(200);
        });

        $this->app->post('/api/line/webhook', function ($request, $response) use ($bot, $pass_signature){
            // get request body and line signature header
            $body       = file_get_contents('php://input');
            $signature  = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : '';
            
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
            
            $data = json_decode($body, TRUE);
            if (is_array($data['events'])) {
                foreach ($data['events'] as $event) {
                    if ($event['message']['type'] === 'text') {
                        $message_per_word = explode(" ",$event['message']['text']);
                        if($message_per_word[0] == "/help"){
                            $text = "Menu perintah bot:\n/daftar = mendaftarkan diri untuk menjadi member\n/lapor	= melaporkan amaliyah sehari-hari\n/cek	= mengecek amaliyah yang sudah atau belum dilaporkan\n/about	= tentang mutabaah chat bot";
                            $result = $bot->replyText($event['replyToken'], $text);
                            return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                        } else {
                            // send same message as reply to user
                            $result = $bot->replyText($event['replyToken'], $event['message']['text']);
                            return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                        }
                    }
                }
            }
        });
        $this->app->run();
    }
    public function api_command_development(){        
        $this->app->post('/api/v1/line_bot/api_command_development', function ($request, $response) {
            $body = file_get_contents('php://input');
            $data = json_decode($body, TRUE);
            if (is_array($data['events'])) {
                foreach ($data['events'] as $event) {
                    if($event['message']['type'] === 'text'){
                        $message_per_word = explode(" ",$event['message']['text']);
                        if($message_per_word[0] == "/help"){
                            $text = "
                            Menu perintah bot:
                            /daftar = mendaftarkan diri untuk menjadi member
                            /lapor	= melaporkan amaliyah sehari-hari
                            /cek	= mengecek amaliyah yang sudah atau belum dilaporkan
                            /about	= tentang mutabaah chat bot
                            ";
                            echo $text;
                        }
                    }
                }
            }
        });
        $this->app->run();
    }
    
    // private function section
    private function bot_init(){
        // set false for production
        $this->pass_signature = true;
        
        // set LINE channel_access_token and channel_secret
        $channel_access_token = isset($_ENV['CHANNEL_ACCESS_TOKEN']) ? $_ENV['CHANNEL_ACCESS_TOKEN'] : "";
        $channel_secret = isset($_ENV['CHANNEL_SECRET']) ? $_ENV['CHANNEL_SECRET'] : "";
        
        // bot object initiation
        $httpClient = new CurlHTTPClient($channel_access_token);
        $this->bot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);
    }

    private function slim_config(){
        $configs =  [
            'settings' => ['displayErrorDetails' => true],
        ];
        $this->app = new Slim\App($configs);
    }
    
    private function environment_is($environment){
        return isset($_ENV['CI_ENV']) && $environment === $_ENV['CI_ENV'] ? TRUE : FALSE;
    }

    private function dotenv_initiation(){
        $dotenv = new Dotenv\Dotenv(__DIR__);
        $dotenv->load();
    }
}
