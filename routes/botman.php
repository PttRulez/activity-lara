<?php

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


$configs = config('botman.bots');

Route::get('/giphy', function() {
    $url = 'http://api.giphy.com/v1/gifs/search?q=table&api_key=obkSCQunkH20KMw92pfqyeiQqB9r5MFN&limit=1';
    $response = Http::get($url);

    dd(
        $response->json()['data'][0]['images']['downsized_small']['mp4'],
        $response->object()->data[0]->images->downsized_small->mp4,
        $response->collect()->get('data')[0]['images']['downsized_small']['mp4'],
    );


    dd($response->object());
    dd($response->collect());
});

Route::post('/botman/test_bot', function (Request $request) use ($configs) {
    DriverManager::loadDriver(TelegramDriver::class);
    $botman = BotManFactory::create(config('botman.bots.test_bot'));
    
    $botman->hears('/gif {name}', function($bot, $name) {
        $url = 'http://api.giphy.com/v1/gifs/search?q=' . urlencode($name) . '&api_key=obkSCQunkH20KMw92pfqyeiQqB9r5MFN&limit=1';
        $response = Http::get($url);
        Log::debug($response->json());
        $image = $response->json()['data'][0]['images']['downsized_small']['mp4'];

        $message = OutgoingMessage::create('This is your gif')
            ->withAttachment(new Image($image));

        $bot->reply("GIF:");
        $bot->reply($message);
    });

    $botman->hears('hello', function (BotMan $bot) {

        $bot->reply('Hello from test_bot!');
    });

    $botman->fallback(function($bot) {
        $bot->reply('I can only reply if you type: \n');
        $bot->reply('"hello"');
    });

    $botman->listen();
});

// 'http://api.giphy.com/v1/gifs/search?q=dog&api_key=obkSCQunkH20KMw92pfqyeiQqB9r5MFN&limit=1';


Route::post('/botman/invest_bot', function (Request $request) use ($configs) {
    DriverManager::loadDriver(TelegramDriver::class);
    $botman = BotManFactory::create(config('botman.bots.invest_bot'));

    $botman->hears('hello', function (BotMan $bot) {
        $bot->reply('Hello from invest_bot!');
    });

    $botman->listen();
});
