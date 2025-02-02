<?php

namespace Al3x5\xBot\Commands\Traits;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

trait Io
{
    protected SymfonyStyle $style;

    protected InputInterface $input;
    protected OutputInterface $output;

    /**
     * Instalcia SymfonyStyle y optiene InputInterface, OutputInterface
     */
    protected function prepare(InputInterface $input, OutputInterface $output): void
    {
        $this->input = $input;
        $this->output = $output;
        $this->style = new SymfonyStyle($input, $output);
    }

    /**
     * Limpia la pantalla
     */
    protected function clear(): void
    {
        $this->output->write("\033[2J\033[;H");
    }
}
