<?php
namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Incoming\Answer;

class OnboardingConversation extends Conversation
{
    protected $firstname;

    public function askName()
    {
        $this->ask('Hello! What is your Name?', function(Answer $answer) {
            // Simulate delay by chaining the next question
            $this->bot->typesAndWaits(2); // Simulate typing delay

            $this->firstname = $answer->getText();
            $this->say('Nice to meet you '.$this->firstname);

            // Simulate delay by chaining the next question
            $this->bot->typesAndWaits(2); // Simulate typing delay
            $this->askPurpose();
        });
    }

    public function askPurpose()
    {
        $question = Question::create("What would you like to know about our website?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_purpose')
            ->addButtons([
                Button::create('About Us')->value('about'),
                Button::create('Contact Info')->value('contact'),
                Button::create('Services')->value('services')
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $value = $answer->getValue();
                switch ($value) {
                    case 'about':
                        $this->say("Welcome to TechNex Solutions, where we commit ourselves to delivering excellence in digital transformation and IT consultancy. Founded in 2012 by Alice Thompson, our company has grown from a passionate venture into a trusted leader in the technology sector. Based in San Francisco, California, we pride ourselves on our innovative approach to solving complex problems and our dedication to client satisfaction.");
                        break;
                    case 'contact':
                        $this->say("Address:
                        TechNex Solutions
                        1234 Innovation Drive
                        San Francisco, CA 94103
                        USA

                        Phone:
                        +1 (415) 789-4561

                        Email:
                        contact@technexsolutions.com");
                        break;
                    case 'services':
                        $this->say("From desktop applications to modern mobile apps, our team has the expertise to build software tailored to your business needs. We utilize the latest technologies to craft systems that are robust, scalable, and secure.");
                        break;
                }
            }
        });
    }

    public function run()
    {
        $this->askName();
    }
}


?>
