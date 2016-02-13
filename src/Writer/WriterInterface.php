<?php
/**
 * @copyright 2013-2016 Hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Writer;

use Hexmedia\Crontab\Crontab;

/**
 * Interface WriterInterface
 * @package Hexmedia\Crontab\Writer
 */
interface WriterInterface
{
    /**
     * @param Crontab $crontab
     * @return bool
     */
    public function write(Crontab $crontab);

    /**
     * @param Crontab $crontab
     * @return string
     */
    public function getContent(Crontab $crontab);
}
