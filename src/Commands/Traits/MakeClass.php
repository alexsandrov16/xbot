<?php

namespace Al3x5\xBot\Commands\Traits;

trait MakeClass
{
    protected function makeCliCommand(string $name, string $command): void
    {
        // Crear el contenido de la clase
        $content = <<<PHP
        <?php
        namespace Al3x5\\xBot\Commands;

        use Symfony\Component\Console\Command\Command;
        use Symfony\Component\Console\Input\InputInterface;
        use Symfony\Component\Console\Output\OutputInterface;

        /**
         * $name command class
         */
        final class {$name}Command extends Command
        {
            public function configure(): void
                {
                    \$this
                    ->setName('$command')
                    ->setDescription('')
                    ->setHelp('');
                }
            public function execute(InputInterface \$input, OutputInterface \$output): int
                {
                    # code...
                }
        }
        PHP;

        writeContentToFile("/{$name}Command.php", $content);
    }

    /**
     * 
     */
    protected function makeTelegramCommand(string $name, string $command): void
    {
        // Crear el contenido de la clase
        $content = <<<PHP
        <?php
        namespace MyBot\Commands;
        
        use Al3x5\\xBot\Commands;
        use Al3x5\\xBot\Telegram;

        use Al3x5\\xBot\Attributes\Command;

        #[Command('$command')]
        class $name extends Commands
        {
            public function execute(array \$params=[]): Telegram
            {
                return \$this->bot->reply('$command command executed');
            }
        }
        PHP;

        writeContentToFile("bot/Commands/{$name}.php", $content);
    }

    /**
     * 
     */
    protected function makeCallback(string $name, string $action): void
    {
        // Crear el contenido de la clase
        $content = <<<PHP
        <?php
        namespace MyBot\Callbacks;
        
        use Al3x5\\xBot\Callbacks;
        use Al3x5\\xBot\Telegram;

        use Al3x5\\xBot\Attributes\Callback;

        #[Callback('$action')]
        class $name extends Callbacks
        {
            public function execute(): Telegram
            {
                return \$this->bot->reply('Callback executed');
            }
        }
        PHP;

        writeContentToFile("bot/Callbacks/{$name}.php", $content);
    }

    protected function makeConversation(string $name): void
    {
        // Crear el contenido de la clase
        $content = <<<PHP
        <?php
        namespace MyBot\Conversations;
        
        use Al3x5\\xBot\Conversation;
        use Al3x5\\xBot\Telegram;

        class $name extends Conversation
        {
            public function execute(array \$params=[]): Telegram
            {
                return \$this->bot->reply('Conversation executed');
            }
        }
        PHP;

        writeContentToFile("bot/Conversations/$name.php", $content);
    }
}