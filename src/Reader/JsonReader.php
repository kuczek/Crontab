<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;

/**
 * Class JsonReader
 * @package Hexmedia\Crontab\Reader
 */
class JsonReader extends FileReaderAbstractArrayReader implements ReaderInterface
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
