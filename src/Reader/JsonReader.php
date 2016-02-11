<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;

/**
 * Class JsonReaderAbstract
 * @package Hexmedia\Crontab\Reader
 */
class JsonReaderAbstract extends AbstractFileReaderAbstract implements ReaderInterface
{
    /**
     * @param string       $file
     * @param Crontab|null $crontab
     * @param string|null  $machine
     */
    public function __construct($file, Crontab $crontab = null, $machine = null)
    {
        parent::__construct($file, $crontab, $machine);
    }

    /**
     * @return array
     */
    protected function parse()
    {
        $parsed = json_decode($this->getContent(), true);

        return $parsed;
    }
}
