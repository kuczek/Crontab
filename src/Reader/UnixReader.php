<?php
/**
 * Created by PhpStorm.
 * User: krun
 * Date: 31.01.16
 * Time: 00:43
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;

abstract class UnixReader extends ArrayReader
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
