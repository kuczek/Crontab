<?php

namespace Hexmedia\Crontab\Console;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Writer\SystemWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SynchronizeCommand extends AbstractCommand
{
    protected function configureName()
    {
        $this
            ->setName("synchronize")
            ->setDescription("Synchronizes with system crontab");
    }

    /**
     * @param OutputInterface $output
     * @param Crontab $crontab
     * @param string|null $user
     * @return mixed
     */
    public function output(OutputInterface $output, Crontab $crontab, $user = null)
    {
        $writer = new SystemWriter(array('user' => $user));

        $writer->save($crontab);

        $output->writeln("Your crontab was updated!");
    }
}
