<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;

/**
 * Interface ReaderInterface
 * @package Hexmedia\Crontab\Reader
 */
interface ReaderInterface
{
    /**
     * @return Crontab
     */
    public function read();
}
