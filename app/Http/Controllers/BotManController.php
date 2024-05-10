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

            // Simulate typing by adding a delay before sending a reply
            $botman->typesAndWaits(2); // Simulate the bot is typing for 2 seconds

            if (strtolower($message) === 'hi' || strtolower($message) === 'hello') {
                $botman->startConversation(new OnboardingConversation);
            } 
            /*elseif(strtolower($message) === 'jawb'){
                $botman->reply("Jawb nta nit :)");
                $botman->typesAndWaits(2);
                $botman->reply("Rah jawbnak layj3el lbaraka >:(");
            }*/
            else {
                $botman->reply("Start a conversation by saying hi.");
            }
        });

        $botman->listen();
    }

}
