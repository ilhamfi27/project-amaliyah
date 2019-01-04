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
    private $channel_access_token;
    private $channel_secret;
    private $pass_signature;
    private $httpClient;
    private $bot;


    public function __construct() {
        if($this->environment_is("development")){
            $this->dotenv_initiation();
        }
        $this->slim_config();
        $this->line_bot_initiation();
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

    private function line_bot_initiation(){
        // set false for production
        $this->pass_signature = true;
        
        // set LINE channel_access_token and channel_secret
        $this->channel_access_token = isset($_ENV['CHANNEL_ACCESS_TOKEN']) ? $_ENV['CHANNEL_ACCESS_TOKEN'] : "";
        $this->channel_secret = isset($_ENV['CHANNEL_SECRET']) ? $_ENV['CHANNEL_SECRET'] : "";
        
        // bot object initiation
        $this->httpClient = new CurlHTTPClient($this->channel_access_token);
        $this->bot = new LINEBot($this->httpClient, ['channelSecret' => $this->channel_secret]);
    }

    private function slim_api(){
        $this->app->get('/api_test', function () {
            return "hello, it works!";
        });
        $this->app->get('/api/line/webhook', function ($request, $response) {
            return $response->withStatus(200);
        });
        $this->app->post('/api/line/webhook', function ($request, $response){
            
            // get request body and line signature header
            $body        = file_get_contents('php://input');
            $signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : '';
            
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
