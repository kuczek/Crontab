<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Console;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Writer\SystemWriter;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SynchronizeCommand
 *
 * @package Hexmedia\Crontab\Console
 */
class SynchronizeCommand extends AbstractCommand
{
    /**
     * @param OutputInterface $output
     * @param Crontab         $crontab
     * @param string|null     $user
     *
     * @return mixed
     */
    public function output(OutputInterface $output, Crontab $crontab, $user = null)
    {
        $writer = new SystemWriter(array('user' => $user));

        $writer->save($crontab);

        $output->writeln('Your crontab was updated!');
    }

    /**
     *
     */
    protected function configureName()
    {
        $this
            ->setName('synchronize')
            ->setDescription('Synchronizes with system crontab');
    }
}
