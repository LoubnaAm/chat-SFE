<?php
namespace App\Http\Controllers;

use App\Conversations\OnboardingConversation;

use Illuminate\Support\Facades\Log;

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function ($botman, $message) {
            $botman->typesAndWaits(2);

            if (strtolower($message) === 'hi' || strtolower($message) === 'hello') {
                $botman->startConversation(new OnboardingConversation());
            } else {
                $botman->reply("Start a conversation by saying hi.");
            }
        });

        $botman->listen();
    }
}
