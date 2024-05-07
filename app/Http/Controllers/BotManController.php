<?php
namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

use Illuminate\Support\Facades\Log;

class BotManController extends Controller
{

    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function ($botman, $message) {
            if ($message === 'hi' || $message === 'Hi' || $message === 'HI' || $message === 'hello' || $message === 'Hello' || $message === 'HELLO') {
                $this->askName($botman);
                //$this->askPurpose($botman);
                //$this->askTest($botman);
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
                $this->askPurpose($botman);

            } catch (\Exception $e) {
                Log::error('Error sending reply: ' . $e->getMessage());
            }
        });
    }

    
    public function askPurpose($botman)
    {
        $question = Question::create("What would you like to know about our website?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_purpose')
            ->addButtons([
                Button::create('About Us')->value('about'),
                Button::create('Contact Info')->value('contact'),
                Button::create('Services')->value('services')
            ]);

        $botman->ask($question, function (Answer $answer,$botman) {
            Log::info("Received answer: " . $answer->getText());

            if ($answer->isInteractiveMessageReply()) {
                $value = $answer->getValue();
                Log::info("Handling value: " . $value);
                $userId = $answer->getMessage()->getSender(); // Get the user ID from the incoming message

                switch ($value) {
                    case 'about':
                        $botman->say("We're a company that...", $userId);
                        Log::info("Message sent: We're a company that...");
                        break;
                    case 'contact':
                        $botman->say("You can contact us via...", $userId);
                        Log::info("Message sent: You can contact us via...");
                        break;
                    case 'services':
                        $botman->say("We offer various services including...", $userId);
                        Log::info("Message sent: We offer various services including...");
                        break;
                    default:
                        $botman->say("Sorry, I didn't understand that.", $userId);
                        Log::info("Message sent: Sorry, I didn't understand that.");
                }
            } else {
                $botman->say("Please use the buttons provided.", $answer->getMessage()->getSender());
            }
        });
    }


    public function askTest($botman)
    {
        $botman->ask('How old are you?', function(Answer $answer, $botman) {
            $name = $answer->getText();
            Log::info('Answer received: ' . $name);

            try {

                $botman->say('You are ' . $name . "yo.\n");
                $botman->replay('You are ' . $name . 'yo.');


                Log::info('Reply sent successfully.');

            } catch (\Exception $e) {
                Log::error('Error sending reply: ' . $e->getMessage());
            }
        });
    }

    
}
