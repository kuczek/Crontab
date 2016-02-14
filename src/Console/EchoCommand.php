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
 * Class EchoCommand
 *
 * @package Hexmedia\Crontab\Console
 */
class EchoCommand extends AbstractCommand
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

        $output->writeln('<info>Your crontab will look like:</info>');
        $output->write('<comment>' . $writer->toCronFile($crontab) . '</comment>');
    }

    /**
     *
     */
    protected function configureName()
    {
        $this
            ->setName('echo')
            ->setDescription('Displays prepared crontable');
    }
}
