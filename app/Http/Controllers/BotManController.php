<?php
namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;

use Illuminate\Support\Facades\Log;

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function ($botman, $message) {
            if ($message === 'hi' || $message === 'Hi' || $message === 'HI' || $message === 'hello' || $message === 'Hello' || $message === 'HELLO') {
                $this->askName($botman);
            } else {
                $botman->reply("Start a conversation by saying hi.");
            }
        });

        $botman->listen();
    }

    public function askName($botman)
    {
        $botman->ask('Hello! What is your Name?', function(Answer $answer, $botman) {
            $name = $answer->getText();
            Log::info('Answer received: ' . $name);

            try {

                $botman->say('Nice to meet you ' . $name);

                Log::info('Reply sent successfully.');

            } catch (\Exception $e) {
                Log::error('Error sending reply: ' . $e->getMessage());
            }
        });
    }

    


}
