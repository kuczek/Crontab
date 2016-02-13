<?php
/**
 * @copyright 2013-2016 Hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;

/**
 * Class UnixReaderAbstract
 * @package Hexmedia\Crontab\Reader
 */
abstract class UnixReaderAbstract extends ArrayReaderAbstract
{
    /**
     * UnixReader constructor.
     * @param Crontab|null $crontab
     */
    public function __construct(Crontab $crontab = null)
    {
        parent::__construct($crontab, null);
    }

    /**
     * @return array
     */
    protected function prepareArray()
    {
        return array();
    }

    /**
     * @return mixed
     */
    abstract protected function getContent();
}
