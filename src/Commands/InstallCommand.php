<?php

namespace Al3x5\xBot\Commands;

use Al3x5\xBot\Bot;
use Al3x5\xBot\Commands\Traits\ConfigHandler;
use Al3x5\xBot\Commands\Traits\Io;
use Al3x5\xBot\Commands\Traits\MakeClass;
use Al3x5\xBot\Events;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Install cli command
 */
final class InstallCommand extends Command
{
    use Io, ConfigHandler, MakeClass;

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

        $output->writeln(sprintf('%s <info>%s</info>', Bot::NAME, Bot::VERSION));
        $this->style->title('Bot configuration process starting...');

        // Solicitar el token del bot
        $token = $this->askForToken();
        $this->clear();

        // Solicitar el nombre del bot
        $name = $this->style->ask(
            'What is your bot name?',
            null,
            function (?string $name): string {
                if (empty($name)) {
                    throw new \InvalidArgumentException('You must specify a name for your bot');
                }
                return $name;
            }
        );
        $this->clear();

        // Solicitar los IDs de los administradores
        $admins = $this->askForAdmins();
        $this->clear();

        // Solicitar si es un entorno de desarrollo
        $debug = $this->style->confirm('Is it development environment?', false) ? 'true' : 'false';
        $this->clear();

        // Crear archivos de configuración
        try {
            // Generar el contenido del archivo de configuración
            $output->writeln('<info>Creating config file...</info>');
            $this->generateConfigData($token, $name, $admins, $debug);

            $output->writeln('<info>Creating directories...</info>');
            $this->createDirectories();

            $output->writeln('<info>Loading bot configuration...</info>');
            self::load(self::configFile());

            $output->writeln('<info>Creating command classes...</info>');
            $this->makeCommandClasses(); // Crear las clases Start y Help

            $output->writeln('<info>Updating composer.json...</info>');
            $this->updateComposerAutoload(); // Actualizar composer.json y autoload

            $output->writeln('<info>Registering commands...</info>');
            // Ejecutar el comando RegisterCommand
            $this->getApplication()->find('register')->run($input, new NullOutput);

            sleep(3);
            $this->clear();
            $this->style->success('Bot configuration has been saved successfully.');
        } catch (\Throwable $th) {
            Events::logger(
                'cli',
                'cli.log',
                'Failed to save bot configuration: ' . $th->getMessage(),
                $th->getTrace()
            );
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
    private function generateConfigData(?string $token, ?string $name, ?string $admins, string $debug): void
    {
        $file = <<<PHP
            <?php

            return [
                'token' => '$token',
                'name' => '$name',
                'admins' => [$admins],
                'dev' => $debug,
                'abs_path' => __DIR__,
            ];
            PHP;

        writeContentToFile(self::configFile(), $file);
    }

    /**
     * Crea directorios
     */
    private function createDirectories(): void
    {
        foreach (self::directories as $directory) {
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0775, true) && !is_dir($directory)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
                }
            }
        }
    }

    /**
     * Crea comandos del bot
     */
    private function makeCommandClasses(): void
    {
        $this->makeTelegramCommand('bot/Commands/Start.php', __DIR__);
        $this->makeTelegramCommand('bot/Commands/Help.php', __DIR__);
        $this->makeTelegramCommand('bot/Commands/Generic.php', __DIR__);
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
        $composerJson['autoload']['psr-4'][botNamespace() . '\\'] = 'bot/';

        // Guardar los cambios en composer.json
        writeContentToFile($composerJsonPath, json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL);

        // Ejecutar el comando para actualizar el autoload
        shell_exec('composer dump-autoload');
    }
}
