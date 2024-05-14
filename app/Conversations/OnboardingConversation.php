<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Incoming\Answer;

class OnboardingConversation extends Conversation
{
    public function askForPath()
    {
        $question = Question::create("Hello there! I'm the TechGuru Assistant. How can I assist you today? 😊")
            ->fallback('Unable to ask question')
            ->callbackId('ask_path')
            ->addButtons([
                Button::create('Browse Services')->value('services'),
                Button::create('Support')->value('support'),
                Button::create('Company Info')->value('info')
            ]);

        $this->ask($question, function (Answer $answer) {
            $this->handlePathResponse($answer);
        });
    }

    public function handlePathResponse(Answer $answer)
    {
        if ($answer->isInteractiveMessageReply()) {
            switch ($answer->getValue()) {
                case 'services':
                    $this->askServices();
                    break;
                case 'support':
                    $this->askSupport();
                    break;
                case 'info':
                    $this->askCompanyInfo();
                    break;
            }
        }
    }


    public function askServices()
    {
        $question = Question::create("We offer a range of IT solutions. What are you interested in?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_services')
            ->addButtons([
                Button::create('Cloud Services')->value('cloud'),
                Button::create('IT Security')->value('security'),
                Button::create('Software Development')->value('software')
            ]);

        $this->ask($question, function (Answer $answer) {
            // Further response handling here...
        });
    }

    public function askSupport()
    {
        $question = Question::create("I'm here to help! What support do you need?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_support')
            ->addButtons([
                Button::create('Troubleshooting')->value('troubleshooting'),
                Button::create('Talk to Support')->value('talk_to_support'),
                Button::create('Billing and Accounts')->value('billing')
            ]);

        $this->ask($question, function (Answer $answer) {
            // Further response handling here...
        });
    }

    public function askCompanyInfo()
    {
        $question = Question::create("Want to know more about us? What are you interested in?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_info')
            ->addButtons([
                Button::create('About Us')->value('about_us'),
                Button::create('Careers')->value('careers'),
                Button::create('Contact Info')->value('contact_info')
            ]);

        $this->ask($question, function (Answer $answer) {
            // Further response handling here...
        });
    }

    public function run()
    {
        $this->askForPath();
    }
}
