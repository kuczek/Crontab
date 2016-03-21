<?php

namespace dev\Hexmedia\Crontab\Test;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Reader\ReaderInterface;

/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */
class TestReader implements ReaderInterface
{
    /**
     * @return Crontab
     */
    public function read()
    {
        return null;
    }
}
