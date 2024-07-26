<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use GuzzleHttp\Client;

class sendMessage {

    const TOKEN = "7448038287:AAE95bOvBJbgulctsyL-WXKoJiRiv3Ej0Ao";
    const TgAPI = 'https://api.telegram.org/bot' . self::TOKEN . '/';

    private Client $client;

    public function __construct() {
        $this->client = new Client(['base_uri' => self::TgAPI]);
    }

    public function startHandler(int $chatId) {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => 'Welcome to my Todo Telegram bot'
            ]
        ]);
    }

    public function addHandler(int $chatId) {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Enter the text 'add'"
            ]
        ]);
    }

    public function getHandler(int $chatId) {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Enter the text 'add'"
            ]
        ]);
    }

    public function checkHandler(int $chatId) {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Enter the text 'add'"
            ]
        ]);
    }

    public function uncheckHandler(int $chatId) {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Enter the text 'add'"
            ]
        ]);
    }

    public function deleteHandler(int $chatId) {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Enter the text 'add'"
            ]
        ]);
    }

    // public function getHandler(int $chatId) {
    //     $this->client->post('sendMessage', [
    //         'form_params' => [
    //             'chat_id' => $chatId,
    //             'text' => "Enter the text 'add'"
    //         ]
    //     ]);
    // }
}