<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Console;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Reader\SystemReader;
use Hexmedia\Crontab\Writer\SystemWriter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ClearCommand
 * @package Hexmedia\Crontab\Console
 */
class ClearCommand extends CommandAbstract
{
    /**
     *
     */
    protected function configureName()
    {
        $this
            ->setName('clear')
            ->setDescription('Clear this project crontabs from this machine');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $user = $input->getOption('user');

        $crontab = new Crontab($user, $name);

        $systemReader = new SystemReader($user, $crontab);

        $systemReader->read();

        $crontab->clearManagedTasks();

        $this->output($output, $crontab, $user);
    }

    /**
     * @param OutputInterface $output
     * @param Crontab         $crontab
     * @param string|null     $user
     * @return mixed
     */
    public function output(OutputInterface $output, Crontab $crontab, $user = null)
    {
        $crontab->clearManagedTasks();

        $writer = new SystemWriter(array('user' => $user));

        $writer->save($crontab);

        $output->writeln('Your crontab was updated!');
    }

    protected function configureArguments()
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Name of project')
            ->addArgument('configuration-file', InputArgument::OPTIONAL, 'Configuration file');
    }
}
