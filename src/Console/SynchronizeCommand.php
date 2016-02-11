<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Console;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Writer\SystemWriter;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SynchronizeCommand
 * @package Hexmedia\Crontab\Console
 */
class SynchronizeCommand extends CommandAbstract
{
    /**
     *
     */
    protected function configureName()
    {
        $this
            ->setName('synchronize')
            ->setDescription('Synchronizes with system crontab');
    }

    /**
     * @param OutputInterface $output
     * @param Crontab         $crontab
     * @param string|null     $user
     * @return mixed
     */
    public function output(OutputInterface $output, Crontab $crontab, $user = null)
    {
        $writer = new SystemWriter(array('user' => $user));

        $writer->save($crontab);

        $output->writeln('Your crontab was updated!');
    }
}
