<?php

/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab;

use Hexmedia\Crontab\Console\ClearCommand;
use Hexmedia\Crontab\Console\EchoCommand;
use Hexmedia\Crontab\Console\SynchronizeCommand;
use Symfony\Component\Console\Application as BaseApplication;

/**
 * Class Application
 *
 * @package Hexmedia\Crontab
 */
class Application extends BaseApplication
{
    /**
     * {@inheritdoc}
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);

        $this->add(new SynchronizeCommand());
        $this->add(new EchoCommand());
        $this->add(new ClearCommand());
    }
}
