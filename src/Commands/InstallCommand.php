<?php

namespace Al3x5\xBot\Commands;

use Al3x5\xBot\AppCli as App;
use Al3x5\xBot\Commands\Traits\ConfigHandler;
use Al3x5\xBot\Commands\Traits\Io;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Install cli command
 */
final class InstallCommand extends Command
{
    use Io, ConfigHandler;

    public function configure(): void
    {
        $this
            ->setName('install')
            ->setDescription('Create bot configuration files.')
            ->setHelp('This command will help you create the necessary configuration files for your bot.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->prepare($input, $output);
        $this->clear();

        $output->writeln(sprintf('%s <info>%s</info>', App::NAME, App::VERSION));
        $this->style->title('Bot configuration process starting...');

        // Solicitar el token del bot
        $token = $this->askForToken();
        $this->clear();

        // Solicitar el nombre del bot
        $name = $this->style->ask('What is your bot name?');
        $this->clear();

        // Solicitar los IDs de los administradores
        $admins = $this->askForAdmins();
        $this->clear();

        // Solicitar si es un entorno de desarrollo
        $debug = $this->style->confirm('Is it development environment?', false) ? 'true' : 'false';
        $this->clear();

        // Generar el contenido del archivo de configuración
        $data = $this->generateConfigData($token, $name, $admins, $debug);

        // Crear archivos de configuración
        try {
            $this->createDirectories();
            writeContentToFile(self::configFile(), $data);
            $this->createCommandClasses(); // Crear las clases Start y Help
            $this->updateComposerAutoload(); // Actualizar composer.json y autoload
            $this->style->success('Bot configuration has been saved successfully.');
        } catch (\Throwable $th) {
            $this->style->error('Failed to save bot configuration: ' . $th->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * Obtener token
     */
    private function askForToken(): string
    {
        return $this->style->ask(
            'What is your bot token?',
            null,
            function (?string $token): string {
                if (!preg_match('/(\d+):[\w\-]+/', $token)) {
                    throw new \InvalidArgumentException('Invalid token. Please verify that the token is correct and try again.');
                }
                return $token;
            }
        );
    }

    /**
     * Obtiene el id de telegram de los admins
     */
    private function askForAdmins(): string
    {
        return $this->style->ask(
            'Enter the IDs of the administrators (separated by commas)',
            null,
            function (?string $ids): string {
                $adm = [];
                if (empty($ids)) {
                    return '';
                }
                foreach (explode(',', $ids) as $value) {
                    if (!is_numeric($value) || strlen((string)$value) < 6) {
                        throw new \InvalidArgumentException("'$value' is not a valid id");
                    }
                    $adm[] = $value;
                }
                return implode(',', $adm);
            }
        );
    }

    /**
     * Archivo de configuracion a generar
     */
    private function generateConfigData(?string $token, ?string $name, ?string $admins, string $debug): string
    {
        return <<<PHP
            <?php

            return [
                'token' => '$token',
                'name' => '$name',
                'admins' => [$admins],
                'dev' => $debug,
                'logs' => 'storage/logs',
                'parse_mode' => 'MarkdownV2',
                'handler' => [
                    '/start' => \MyBot\Commands\Start::class,
                ]
            ];
            PHP;
    }

    /**
     * Crea directorios
     */
    private function createDirectories(): void
    {
        $directories = [
            'storage/logs',
            'storage/cache',
            'bot/Commands',
            'bot/Conversations'
        ];

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
                }
            }
        }
    }

    /**
     * Crea comandos del bot
     */
    private function createCommandClasses(): void
    {
        $commands = [
            'Start' => <<<PHP
            <?php
            namespace MyBot\Commands;

            use Al3x5\\xBot\Commands;
            use Al3x5\\xBot\Telegram;

            /**
             * Start command class
             */
            final class Start extends Commands
            {
                public function execute(array \$params=[]): Telegram
                {
                    return \$this->bot->reply('Start command executed');
                }
            }
            PHP,
            'Help' => <<<PHP
            <?php
            namespace MyBot\Commands;

            use Al3x5\\xBot\Commands;
            use Al3x5\\xBot\Telegram;

            /**
             * Help class
             */
            final class Help extends Commands
            {
                public function execute(array \$params=[]): Telegram
                {
                    return \$this->bot->reply('Help message');
                }
            }
            PHP
        ];

        foreach ($commands as $className => $classContent) {
            writeContentToFile("bot/Commands/{$className}.php", $classContent);
        }
    }

    /**
     * Actualizar composer
     */
    private function updateComposerAutoload(): void
    {
        $composerJsonPath = 'composer.json';

        if (!file_exists($composerJsonPath)) {
            throw new \RuntimeException('composer.json file does not exist.');
        }

        $composerJson = json_decode(file_get_contents($composerJsonPath), true);
        // Asegurarse de que la sección de autoload existe
        if (!isset($composerJson['autoload'])) {
            $composerJson['autoload'] = [];
        }

        // Agregar o actualizar la sección de psr-4
        $composerJson['autoload']['psr-4']['MyBot\\'] = 'bot/';

        // Guardar los cambios en composer.json
        writeContentToFile($composerJsonPath, json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL);

        // Ejecutar el comando para actualizar el autoload
        shell_exec('composer dump-autoload');
    }
}
